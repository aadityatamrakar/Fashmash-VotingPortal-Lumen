<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Aaditya Tamrakar">
        <title>IMT Ghaziabad - Coming Soon</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="/css/soon.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    </head>
    <!-- START BODY -->
<body class="nomobile">

<!-- START HEADER -->
<section id="header">
    <div class="container">
        <header>
            @include('nav', ['nav_title'=>"Fantasy League"])
            <h1 data-animated="GoIn"><img src="/img/logo.png" alt="Logo" style="width: 150px; height: 150px;"></h1>
        </header>
        <!-- START TIMER -->
        <div id="timer" data-animated="FadeIn">
            <p id="message"></p>
            <div id="days" class="timer_box"></div>
            <div id="hours" class="timer_box"></div>
            <div id="minutes" class="timer_box"></div>
            <div id="seconds" class="timer_box"></div>
        </div>
        <!-- END TIMER -->
        <div class="col-lg-4 col-lg-offset-4 mt centered">
            <h4>*Disclaimer: Player costs have been allocated by respective sports captains.</h4>
            <a href="{{ route('register') }}" class="btn btn-info">Register</a>
        </div>

    </div>
    <!-- LAYER OVER THE SLIDER TO MAKE THE WHITE TEXTE READABLE -->
    <div id="layer"></div>
    <!-- END LAYER -->
    <!-- START SLIDER -->
    <div id="slider" class="rev_slider">
        <ul>
            <li data-transition="slideleft" data-slotamount="1" data-thumb="/img/bg/0.jpg">
                <img src="/img/bg/0.jpg">
            </li>
            <li data-transition="slideleft" data-slotamount="1" data-thumb="/img/bg/1.jpg">
                <img src="/img/bg/1.jpg">
            </li>
            <li data-transition="slideleft" data-slotamount="1" data-thumb="/img/bg/2.jpg">
                <img src="/img/bg/2.jpg">
            </li>
            <li data-transition="slideleft" data-slotamount="1" data-thumb="/img/bg/3.jpg">
                <img src="/img/bg/3.jpg">
            </li>
        </ul>
    </div>
    <!-- END SLIDER -->
</section>
<!-- END HEADER -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="/js/plugins.js"></script>
<script src="/js/jquery.themepunch.revolution.min.js"></script>
<script src="/js/custom.js"></script>
</body>
<!-- END BODY -->
</html>