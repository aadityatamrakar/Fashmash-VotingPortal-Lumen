<?php
/*
 * Guest Pages Website
 */
$app->get('/', ['as' => 'home', function () {
    session_start();

    $players = \App\Player::inRandomOrder()->get();
    $player_1 = $players[0];
    $player_2 = $players[1];

    $_SESSION['player_1'] = $player_1->id;
    $_SESSION['player_2'] = $player_2->id;

    return view()->make('index', compact(['player_1', 'player_2']));
}]);
$app->get('/vote/{winner}', ['as' => 'vote', 'uses'=>"RateController@vote"]);
$app->get('/contact', ['as' => 'contact', function () {
    return view()->make('contact');
}]);
$app->get('/trending', ['as' => 'trending', function () {
    $players = \App\Player::orderBy('score', 'desc')->paginate(10);
    return view()->make('trending', compact('players'));
}]);

/*
 * Login & Register Routes with Code
 */
$app->get('/login', ['as' => 'login', function () {
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['name'])) {
        if(\App\Team::where('user_id', $_SESSION['user_id'])->first() != null)
            return redirect()->route('view_team');
        else return redirect()->route('make_team');
    }else
        return view()->make('login');
}]);
$app->post('/login', [function (\Illuminate\Http\Request $request) {
    if(($user=\App\User::where([['username', $request->username],['password', $request->password]])->first()) != null)
    {
        session_start();
        $_SESSION['username'] = $request->username;
        $_SESSION['name'] = $user->name;
        $_SESSION['user_id'] = $user->id;

        $user_id = str_replace('','', $_SESSION['user_id']);

        if(\App\Team::where('user_id', $user_id)->first() != null)
            return redirect()->route('view_team');
        else
            return redirect()->route('make_team');

    }else{
        return ("Login Failed, Check and try again.");
    }
}]);
$app->get('/register', ['as' => 'register', function () {
    session_start();
    return view()->make('register');
}]);
$app->post('/register', [function (\Illuminate\Http\Request $request) {
    if(\App\User::where('username', $request->username)->first() == null){
        \App\User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>$request->password
        ]);
        return ['status'=>'ok'];
    }else return ['status'=>"error", "error"=>"username_taken"];

    dd($request);
}]);
$app->get('/logout', ['as' => 'logout', function () {
    session_start();
    session_destroy();
    session_unset();
    return redirect()->route('login');
}]);

/*
 * Team Portal Pages
 */
$app->get('/team/build', ['as' => 'make_team', function () {
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['name'])){
        return view()->make('make_team', ["name"=>$_SESSION['name'], 'user_id'=>$_SESSION['user_id']]);
    }else{
        return redirect()->route('login');
    }
}]);
$app->get('/team/view', ['as' => 'view_team', function () {
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['name'])){
        $team = \App\Team::where('user_id', $_SESSION['user_id'])->first();
        $team_members = \App\TeamMap::where('team_id', $team->id)->get();
        $players = array();
        foreach ($team_members as $player)
        {
            $players[] = \App\Player::find($player->player_id);
        }
        return view()->make('team_view', ["name"=>$_SESSION['name'], 'user_id'=>$_SESSION['user_id'], 'team'=>$team, 'players'=>$players]);
    }else{
        return redirect()->route('login');
    }
}]);
$app->post('/create_team', ['as' => 'save_team', function () {
    session_start();
    if(! isset($_SESSION['user_id'])) return ['status'=>'error', 'error'=>'no_user'];

    $user_id = str_replace('','', $_SESSION['user_id']);

    if(\App\Team::where('user_id', $user_id)->first() != null){
        return ['status'=>'error', 'error'=>'already_created'];
    }

    $team_name = $_POST['name'];

    if(\App\Team::where('name', $team_name)->first() != null){
        return ['status'=>'error', 'error'=>'team_name_taken'];
    }

    $players_ids = json_decode($_POST['players']);
    $total = $male = $female = $cost = 0;

    for($i=0; $i<count($players_ids);$i++)
    {
        $player = \App\Player::find($players_ids[$i]);
        $cost += $player->value;
        $total += 1;
        if($player->gender == 'M') $male += 1;
        else $female += 1;
    }

    if($cost < 191)
    {
        if($total < 26){
            if($male < 21){

                $team = \App\Team::create([
                    'name'=>$team_name,
                    'cost'=>$cost,
                    'total'=>$total,
                    'male'=>$male,
                    'female'=>$female,
                    'user_id'=>$user_id
                ]);

                for($i=0; $i<count($players_ids); $i++)
                {
                    \App\TeamMap::create(["team_id"=>$team->id, "player_id"=>$players_ids[$i]]);
                }

                return ['status'=>'ok'];
            }else return ['status'=>'error', 'error'=>'male_exceeded'];
        }else return ['status'=>'error', 'error'=>'count_exceeded'];
    }else return ['status'=>'error', 'error'=>'cost_exceeded'];

}]);
$app->get('/players', ['as' => 'players', function () {
    session_start();
    if(isset($_SESSION['user_id']))
        return \App\Player::select('id', 'name as n', 'gender as g', 'value as v', 'sports_played as s')->orderBy('name', 'asc')->get();
}]);
$app->get('/delete/team/{username}', ['as' => 'delete_team', function ($username) {

    $user = \App\User::where('username', $username)->first();
    $team = \App\Team::where('user_id', $user->id)->first();
    \App\TeamMap::where('team_id', $team->id)->delete();
    \App\Team::where('user_id', $user->id)->delete();

    return redirect()->route('make_team');
}]);
