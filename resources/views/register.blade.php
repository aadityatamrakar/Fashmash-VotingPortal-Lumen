@extends('app')

@section('content')
    <div class="container">
        @include('nav')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form class="form-horizontal" method="post" onsubmit="return false;">
                    <fieldset>
                        <!-- Form Name -->
                        <legend>User Registration</legend>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Full Name</label>
                            <div class="col-md-6">
                                <input id="name" name="name" type="text" class="form-control input-md" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="email">Email ID</label>
                            <div class="col-md-6">
                                <input id="email" name="email" type="text" class="form-control input-md" required="">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="username">Login Username</label>
                            <div class="col-md-6">
                                <input id="username" name="username" type="text" class="form-control input-md" required="">
                            </div>
                        </div>
                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="password">Login Password</label>
                            <div class="col-md-6">
                                <input id="password" name="password" type="password" class="form-control input-md" required="">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="register"></label>
                            <div class="col-md-4">
                                <button id="register" name="register" class="btn btn-success">Register</button>
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#register").click(function (e){
            e.preventDefault();

            var name = $("#name");
            var email = $("#email");
            var username = $("#username");
            var password = $("#password");
            if(name.val()=='' || username.val() =='' || password.val() == '')
                alert('Kindly enter all the details.');
            else{
                $.ajax({
                    url: "{{ route('register') }}",
                    type: 'POST',
                    data: {name: name.val(), email: email.val(), username: username.val(), password: password.val()}
                }).done(function (res) {
                    if(res.status == 'ok') {
                        if(confirm('User created successfully, Login Now ?')){
                            window.location.href = "{{ route('login') }}";
                        }
                    }else if(res.status == 'error'){
                        if(res.error == 'username_taken'){
                            alert('Username already taken by some other user. ');
                            username.focus();
                        }
                    }
                });
            }
        })
    </script>
@endsection