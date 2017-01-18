@extends('app')

@section('content')
    <div class="container">
        @include('nav')
        <h3>Trending</h3>
        <hr>

        <table class="table table-responsive" id="player_tbl">
            <thead>
            <tr>
                <th>#</th>
                <th>Profile Pic</th>
                <th>Name</th>
                <th>Sports</th>
            </tr>
            </thead>
            <tbody>
            @foreach($players as $index=>$player)
                <tr>
                    {{--<td>{{ (($players->currentPage()-1)*$players->perPage())+($index+1) }}</td>--}}
                    <td>{{$index+1}}</td>
                    <td><a target="_blank" href="/img/profile/{{ $player->id }}.jpg"><img style="height: 80px;" src="/img/profile/thumbs/{{ $player->id }}.jpg" height="80px" class="img-responsive img-thumbnail" /></a></td>
                    <td>{{$player->name}}</td>
                    <td>{{$player->sports_played}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
