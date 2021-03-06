<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('make_team') }}">{{ isset($nav_title)?$nav_title:'Team Portal' }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('home') }}">Voting Page</a></li>
                <li><a href="{{ route('trending') }}">Trending Players</a></li>
                @if(! isset($_SESSION['username']))
                    @if( ($res = \App\Http\Controllers\RateController::check_launch()) != false )
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    @if(isset($_SESSION['user_id']) && \App\Team::where('user_id', $_SESSION['user_id'])->first() == null)
                        @if( ($res = \App\Http\Controllers\RateController::check_launch()) != false )
                            <li><a href="{{ route('make_team') }}">Make Team</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('view_team') }}">Team Score</a></li>
                    @endif
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
