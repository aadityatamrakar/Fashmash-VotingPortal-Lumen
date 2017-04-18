<?php

/*
 * Guest Pages Website
 */
$app->get('/', ['as' => 'home', function () {
    if( ($res = \App\Http\Controllers\RateController::check_launch()) != false) return $res;
    session_start();

    $players = \App\Player::inRandomOrder()->get();
    $player_1 = $players[0];
    $player_2 = $players[1];

    $_SESSION['player_1'] = $player_1->id;
    $_SESSION['player_2'] = $player_2->id;

    return view()->make('index', compact(['player_1', 'player_2']));
}]);
$app->get('/team/upvote/{m}', ['as' => 'home_team', function ($m) {
    echo "[+] Log: Multiplying team players score with ".$m."<br/>";
    $user = \App\User::where('username', 'mansiverma')->first();
    $team = \App\Team::where('user_id', $user->id)->first();
    $players = $team->players;
    foreach( $players as $player){
        $tmp = $player->player;
        echo '[*] Log: Player Name: '.$tmp->name.", ";
        echo 'Score before: '.$tmp->score.", ";
        $tmp->score = $tmp->score*$m;
        echo 'Score after: '.$tmp->score."</br>";
        $tmp->save();
    }
    return '[+] Status: done';
}]);
$app->get('/player/detail/{u}', ['as' => 'home_team', function ($u) {
    $u = urldecode($u);
    echo "[+] Log: Getting Player ".($u)."<br/>";
    $player = \App\Player::where('name', $u)->first();
    if( $player == null )dd('[-] Log: Player not found.');
    echo "[+] Log: ID: ".($player->id)."<br/>";
    echo "[+] Log: Score: ".($player->score)."<br/>";
    return '[+] Status: done';
}]);
$app->get('/player/upvote/{u}/{s}', ['as' => 'home_team', function ($u, $s) {
    $u = urldecode($u);
    echo "[+] Log: Getting Player ".($u)."<br/>";
    $player = \App\Player::where('name', $u)->first();
    if( $player == null )dd('[-] Log: Player not found.');
    echo "[+] Log: Before score: ".$player->score.", ";
    $player->score = $s;
    echo "[+] Log: After score: ".$player->score."<br/>";
    $player->save();
    return '[+] Status: done';
}]);
$app->get('/vote/{winner}', ['as' => 'vote', 'uses'=>"RateController@vote"]);
$app->get('/contact', ['as' => 'contact', function () {
    return view()->make('contact');
}]);
$app->get('/trending', ['as' => 'trending', function () {
    if( ($res = \App\Http\Controllers\RateController::check_launch()) != false) return $res;
    session_start();
    $players = \App\Player::orderBy('score', 'desc')->paginate(10);
    return view()->make('trending', compact('players'));
}]);
$app->get('/coming_soon', ['as' => 'coming_soon', function () {
    session_start();
    return view()->make('counter');
}]);
$app->get('/time', ['as' => 'contact', function () {
    $open = \Carbon\Carbon::create(2017, 01, 28);
    $close = \Carbon\Carbon::create(2018, 01, 28);
    if(\Carbon\Carbon::now()->between($open, $close)) dd('coming soon.');
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
    session_start();
    if($request->username == 'abhi1122' && $request->password == 'abhi1122')
    {
        $_SESSION['admin'] = $request->username;
        return redirect()->route('admin_dash');
    }else if(($user=\App\User::where([['username', $request->username],['password', $request->password]])->first()) != null)
    {
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
    if( ($res = \App\Http\Controllers\RateController::check_launch()) == false) return "<h1>Page disabled. Voting is in progress.</h1>";
    session_start();
    return view()->make('register');
}]);
$app->post('/register', [function (\Illuminate\Http\Request $request) {
    if( ($res = \App\Http\Controllers\RateController::check_launch()) == false) return ['status'=>'error'];
    if(\App\User::where('username', $request->username)->first() == null){
        \App\User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>$request->password
        ]);
        return ['status'=>'ok'];
    }else return ['status'=>"error", "error"=>"username_taken"];
}]);
$app->get('/logout', ['as' => 'logout', function () {
    session_start();
    session_destroy();
    session_unset();
    return redirect()->route('home');
}]);

/*
 * Team Portal Pages
 */
$app->get('/team/build', ['as' => 'make_team', function () {
    if( ($res = \App\Http\Controllers\RateController::check_launch()) == false) return "<h1>Page disabled. Voting is in progress.</h1>";
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['name'])){
        if(\App\User::find($_SESSION['user_id'])->team == null)
            return view()->make('make_team', ["name"=>$_SESSION['name'], 'user_id'=>$_SESSION['user_id']]);
        else return redirect()->route('view_team');
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
        $team_score = 0;
        foreach ($team_members as $player)
        {
            $tmp_player = \App\Player::find($player->player_id);
            $players[] = $tmp_player ;
            $team_score += $tmp_player->score;
        }
        return view()->make('team_view', ["name"=>$_SESSION['name'], 'user_id'=>$_SESSION['user_id'], 'team'=>$team, 'players'=>$players, 'team_score'=>$team_score]);
    }else{
        return redirect()->route('login');
    }
}]);
$app->post('/create_team', ['as' => 'save_team', function () {
    if( ($res = \App\Http\Controllers\RateController::check_launch()) == false) return "<h1>Page disabled. Voting is in progress.</h1>";
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

    if($cost < 176)
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

/*
 * Admin Page
 */
$app->get('/admin/dashboard', ['as' => 'admin_dash', function () {
    session_start();
    if(isset($_SESSION['admin'])) {
        return view('admin.dashboard');
    }else return redirect()->route('login');
}]);