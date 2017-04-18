<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fantasy League Game</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Admin Portal</a>

            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a target="_blank" href="{{ route('home') }}">Voting Page</a></li>
                    <li><a target="_blank" href="{{ route('trending') }}">Tending Players</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
    <hr>
    <table class="table table-responsive">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Username</th>
            <th>email</th>
            <th>Team Name</th>
            <th>Score</th>
        </tr>
        </thead>
        <tbody id="tbl">
        </tbody>
    </table>

</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script>
    var team = [
            @foreach(\App\Team::all() as $index=>$team)
            {
                name: '{{ $team->user->name }}',
                username: '{{ $team->user->username }}',
                email: '{{ $team->user->email }}',
                team_name: '{{ $team->name }}',
                @foreach($team->players as $player)
                    <?php $team->score += $player->player->score; ?>
                @endforeach
                team_score: {{ $team->score }}
            },
            @endforeach
        ];

    $(document).ready(function (){
        render_table(team);
    });

    function render_table(){
        var sort = _.sortBy(team, function (v){ return v.team_score; }).reverse(), html= '';
        $.each(sort, function (i, v) {
            html += "<tr>" +
                "<td>" + (i+1) + "</td><td>" + v.name + "</td><td>" + v.username+
                "</td><td>" + v.email + "</td><td>" + v.team_name + "</td><td>" +
                v.team_score + "</td></tr>";
        });
        $("#tbl").html(html);
    }
    $('[data-toggle="delete_team"]').click(function (){

    })
</script>
</body>
</html>
