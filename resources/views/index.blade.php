@extends('app')

@section('style')
    <link href="/css/cover.css" rel="stylesheet">
@endsection

@section('content')
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">IMT Ghaziabad</h3>
                        <nav>
                            <ul class="nav masthead-nav">
                                <li><a href="{{ route('trending') }}">Trending</a></li>
                                @if(!isset($_SESSION['username']))
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                @else
                                    <li><a href="{{ route('view_team') }}">Team Score</a></li>
                                    <li><a href="{{ route('logout') }}">Logout</a></li>
                                @endif
                                {{--<li><a href="{{ route('contact') }}">Contact</a></li>--}}
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="inner cover">
                    <h1 class="cover-heading">Voting Page</h1>
                    <p class="lead">Who would you rather have in your team ?</p>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="thumbnail" onclick="window.location='{{ route('vote', ['winner'=>'left']) }}'">
                            <img src="/img/profile/{{ $player_1->id }}.jpg" onerror="this.src='https://placeholdit.imgix.net/~text?txtsize=80&txt=Profile%20Pic&w=350&h=350'" alt="player 1">
                            <div class="caption">
                                <h3>{{ $player_1->name }}</h3>
                                <p>{{ $player_1->sports_played }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="thumbnail" onclick="window.location='{{ route('vote', ['winner'=>'right']) }}'">
                            <img src="/img/profile/{{ $player_2->id }}.jpg" alt="player 2" onerror="this.src='https://placeholdit.imgix.net/~text?txtsize=80&txt=Profile%20Pic&w=350&h=350'">
                            <div class="caption">
                                <h3>{{ $player_2->name }}</h3>
                                <p>{{ $player_2->sports_played }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>Developed by <a href="http://www.facebook.com/aaditya.tamrakar.9" target="_blank">Aaditya Tamrakar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection