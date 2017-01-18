@extends('app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/css/jquery.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        @include('nav')
        <h3>Score List of Team : {{ $team->name }}</h3>
        <hr>
        <table class="table table-responsive" id="player_tbl">
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
                    <td>{{$player->value}}</td>
                    <td>{{round($player->score, 1)}}</td>
                    <td>{{$player->sports_played}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#player_tbl").dataTable();
        });
    </script>
@endsection