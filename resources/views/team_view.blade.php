@extends('app')

@section('content')
    <div class="container">
        @include('nav')
        <h3>Score List of Team : {{ $team->name }}, Team Score : {{ round($team_score, 2) }}</h3>
        <hr>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Value</th>
                <th>Score</th>
                <th>Sports</th>
            </tr>
            </thead>
            <tbody>
            @foreach($players as $index=>$player)
                <tr>
                    {{--<td>{{ (($players->currentPage()-1)*$players->perPage())+($index+1) }}</td>--}}
                    <td>{{$index+1}}</td>
                    <td>{{$player->name}}</td>
                    <td>{{round($player->value, 1)}}</td>
                    <td>{{round($player->score, 1)}}</td>
                    <td>{{$player->sports_played}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
