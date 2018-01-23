<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ Request::root() }}/assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ Request::root() }}/assets/plugins/bootstrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ Request::root() }}/assets/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ Request::root() }}/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="{{ Request::root() }}/bami/css/bami.css" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/assets/css/style.css">

@yield('cssLinks')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
<body>

@include ('includes.header')

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">

@include('includes.leftmenu')
@include('includes.chat')


<!-- BEGIN PAGE CONTAINER-->
    <div class="page-content">
        <div class="clearfix"></div>
        <div class="content">

            @yield('content')

        </div>
    </div>

    <!-- END PAGE CONTAINER-->


</div>

<!-- Scripts -->

<!-- BEGIN JS DEPENDECENCIES-->
<script src="{{ Request::root() }}/assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>



<script src="{{ Request::root() }}/assets/plugins/jwplayer/jwplayer.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/js/angular/video/play-solo.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/js/angular/video/play.js" type="text/javascript"></script>


<!-- END CORE JS DEPENDECENCIES-->
<script src="https://content.jwplatform.com/libraries/dRqs0zVG.js"></script>

<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{ Request::root() }}/bami/js/bami.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/assets/js/chat.js" type="text/javascript"></script>
<script src="{{ Request::root() }}/bami/js/bundle.js" type="text/javascript"></script>


<!-- END CORE TEMPLATE JS -->


<script src="{{ Request::root() }}/js/scripts.js" type="text/javascript"></script>

@yield('javascript')

</body>
</html>
