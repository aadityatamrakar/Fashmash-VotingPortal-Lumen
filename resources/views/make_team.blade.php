@extends('app')

@section('style')
    <style>
        .media{
            border: 2px solid #ccc;
            padding: 5px 0px 5px 5px;
            margin-bottom: 5px;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .media:hover{
            box-shadow: 2px 2px 2px #ddd;
            cursor: pointer;
        }
        .glow_green:hover{
            box-shadow: 2px 2px 2px #227cff;
        }
        .glow_green{
            border: 2px solid #227cff !important;
            box-shadow: 2px 2px 2px #227cff;
        }
        @media(min-width: 992px){
            .input-group{
                margin-top: 15px;
            }
        }
        @media(max-width: 768px){
            .input-group{
                margin-bottom: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @include('nav')
        <form class="form-horizontal" method="post" action="" onsubmit="return false;">
            <fieldset>
                <legend>Create Your Team</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="team_name">Team Unique Name</label>
                    <div class="col-md-6">
                        <input id="team_name" name="team_name" type="text" class="form-control input-md">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="team_name">Players (Select from below)</label>
                    <div class="col-md-3">
                        <input id="total_players" name="total_players" value="Total: 0, Male: 0, Female: 0" type="text" readonly class="form-control input-md">
                    </div>
                    <label class="col-md-1 control-label" for="total_cost">Rs. Left</label>
                    <div class="col-md-2">
                        <input id="total_cost" name="total_cost" value="" type="text" readonly class="form-control input-md">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Submit</label>
                    <div class="col-md-6">
                        <button class="btn btn-primary" onclick="review_team()">Create</button>
                        <button class="btn btn-warning" data-toggle="sort_players" data-type="selected_only">Show Selected Players</button>
                        <button class="btn btn-success" data-toggle="sort_players" data-type="all">Show All</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="visible-md visible-lg">Select Team Members</h3>
                                <h4 class="hidden-md hidden-lg" style="text-align: center;">Select Team Members</h4>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control input-sm" placeholder="Search by Player Name" id="query">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="glyphicon glyphicon-sort"></i> Sort <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="#" data-toggle="sort_players" data-type="all">Show All</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="cost_l_to_h">Cost: Low to High</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="cost_h_to_l">Cost: High to Low</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="gender_male">Gender: Male Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="gender_female">Gender: Female Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="cricket">Sport: Cricket Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="tt">Sport: TT Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="tennis">Sport: Tennis Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="volleyball">Sport: Volleyball Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="badminton">Sport: Badminton Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="basketball">Sport: Basketball Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="football">Sport: Football Only</a></li>
                                            <li><a href="#" data-toggle="sort_players" data-type="sport" data-sport="throwball">Sport: Throwball Only</a></li>
                                        </ul>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-offset-2 col-md-8 col-xs-12">
                        <div class="row" id="player_content"></div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <hr>
    </div> <!-- /container -->

    <!-- Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Review Team</h4>
                </div>
                <table class="table table-reponsive">
                    <thead>
                    <tr>
                        <th colspan="5">Team Name: <span id="m_team_name"></span></th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Player Name</th>
                        <th>Gender</th>
                        <th>Sports</th>
                        <th style="text-align: right; padding-right: 10px;">Cost (in Lacs)</th>
                    </tr>
                    </thead>
                    <tbody id="m_player_data"></tbody>
                    <tfoot>
                    <tr>
                        <td>Total</td>
                        <td colspan="3">T: <span id="m_total"></span>, M: <span id="m_total_male"></span>, F: <span id="m_total_female"></span></td>
                        <td style="text-align: right; padding-right: 10px;"><span id="m_cost"></span></td>
                    </tr>
                    </tfoot>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit_team()">Create</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/unveil/1.3.0/jquery.unveil.min.js"></script>
    <script>
        var players = [];
        var total=0, male=0, female=0, budget=175, cost=0;
        $(document).ready(function (){
            $.ajax({
                url: '{{ route('players') }}',
                type: 'GET'
            }).done(function (data){
                players = data;
                render_players(players);
            });
        });
        $("#query").on('keyup', function (e){
            search();
        });
        function search(){
            query = $('#query').val();
            render_players(_.filter(players, function (v) { if(v.n.toLowerCase().indexOf(query.toLowerCase()) != -1) return v; }));
        }
        function select_player(element, id){
            var index = players.indexOf(_.where(players, {id:id})[0]);
            if($(element).hasClass('glow_green')){
                $(element).removeClass('glow_green');
                delete players[index]['selected'];
            }else{
                if((players[index]['v']+cost) < budget){
                    if(total < 25){
                        if(male<20){
                            apply_select(element, index);
                        }else if(players[index]['g'] == 'F'){
                            apply_select(element, index);
                        }else alert("Male members are 20, add female players now.");
                    }else alert("Total Members are 25 now. Maximum team limit reached.");
                }else alert("Cannot add this player, Budget will exceed.");

            }
            update_count();
        }
        function apply_select(element, index){
            $(element).addClass('glow_green');
            players[index]['selected'] = true;
        }
        function update_count(){
            var selected = _.where(players, {selected: true});
            total = selected.length;
            male = _.where(selected, {g: 'M'}).length;
            female = total-male;
            cost = 0;
            $.each(selected, function(i, v){
                cost += v.v;
            });
            $("#total_players").val('Total: '+total+', Male: '+male+', Female: '+female);
            $("#total_cost").val((175-cost).toFixed(1)+' Lacs');
        }
        function render_players(data){
            var html='';
            $.each(data, function(i, v){
                html += make_player_media(v);
            })
            $("#player_content").html(html);
            $("img").unveil(200);
            $('[data-toggle="select_player"]').click(function (e){
                e.preventDefault();
                console.log(this);
                select_player(this, $(this).data('id'));
            });
        }
        function make_player_media(player){
            var id=player['id'], name=player['n'], gender=player['g']=='M'?'Male':'Female', value=player['v'], sports=player['s'];
            var html = '';
            html += '<div class="col-sm-6">' +
                '<div class="media';
            if(player.hasOwnProperty('selected') && player['selected'] == true){
                html += ' glow_green ';
            }
            html += '" data-toggle="select_player" data-id="'+id+'">' +
                '<div class="media-left"><a href="#">' +
                '<img class="media-object img-thumbnail img-responsive" ' +
                'src="https://placeholdit.imgix.net/~text?txtsize=35&txt=NA&w=75&h=75" ' +
                'data-src="/img/profile/thumbs/'+id+'.jpg' +
                '" style="height: 85px" onerror=\'this.src = "https://placeholdit.imgix.net/~text?txtsize=35&txt=NA&w=75&h=75"\'>' +
                '</a></div><div class="media-body"><h4 class="media-heading">'+name+'</h4>' +
                '<p><i class="glyphicon glyphicon-user"></i> '+gender+', Cost: '+value.toFixed(1)+' Lacs<br/>Sports: '+sports+'</p>'+
                '</div></div></div>';
            return html;
        }
        $('[data-toggle="sort_players"]').click(function (e){
            e.preventDefault();
            var type = $(this).data('type');
            if(type == 'all'){
                render_players(players);
            }else if(type == 'cost_l_to_h'){
                render_players(_.sortBy(players, 'v'));
            }else if(type == 'cost_h_to_l'){
                render_players(_.sortBy(players, 'v').reverse());
            }else if(type == 'gender_male'){
                render_players(_.where(players, {g:'M'}));
            }else if(type == 'gender_female'){
                render_players(_.where(players, {g:'F'}));
            }else if(type == 'sport'){
                var sport = $(this).data('sport');
                render_players(_.filter(players, function (v){ if(v.s.toLowerCase().indexOf(sport.toString())!=-1) return v; }));
            }else if(type == 'selected_only'){
                render_players(_.where(players, {selected:true}));
            }
        });
        function review_team(){
            var team_name = $("#team_name").val();
            var selected = _.where(players, {selected: true});
            var html = '';
            if(selected.length == 25){
                for(var i=0;i<selected.length;i++)
                {
                    html += '<tr>' +
                        '<td>'+(i+1)+'</td>' +
                        '<td>'+selected[i]['n']+'</td>' +
                        '<td>'+(selected[i]['g']=='M'?'Male':'Female')+'</td>' +
                        '<td>'+selected[i]['s']+'</td>' +
                        '<td style="text-align: right; padding-right: 10px;">'+selected[i]['v'].toFixed(1)+'</td>' +
                        '</tr>';
                }
                $("#m_team_name").html(team_name);
                $("#m_cost").html(cost.toFixed(2));
                $("#m_total").html(total);
                $("#m_total_male").html(male);
                $("#m_total_female").html(female);
                $("#m_player_data").html(html);
                $("#reviewModal").modal('show');
            }else{
                alert("Minimum players required to make team is 25. Select 25 players.")
            }

        }
        function submit_team(){
            var team_name = $("#team_name").val();
            if(team_name.length > 0)
            {
                var selected = _.map(_.where(players, {selected: true}), function (v, i){ return v.id; });

                $.ajax({
                    url: "{{ route('save_team') }}",
                    type: "POST",
                    data: {name: team_name, total: total, male: male, female: female, cost: cost, players: JSON.stringify(selected)}
                }).done(function (res){
                    if(res.status == 'ok'){
                        $("#reviewModal").modal('hide');
                        alert('Team Created Successfully.');
                        window.location.href = '{{ route('view_team') }}';
                    }else if(res.status == 'error'){
                        $("#reviewModal").modal('hide');

                        if(res.error == 'team_name_taken') alert('Team name already used by some other user.');
                        else if(res.error == 'already_created') alert('Team already Created.');
                        else if(res.error == 'male_exceeded') alert('Team has more than 20 male players.');
                        else if(res.error == 'count_exceeded') alert('Team total member count exceeded.');
                        else if(res.error == 'cost_exceeded') alert('Team budget limit exceeded.');
                    }
                });
            }else{
                alert("Team name required.");
                $("#reviewModal").modal('hide');
                $("#team_name").focus();
            }
        }
    </script>
@endsection