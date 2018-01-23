<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">


    <title>{{ config('app.name', 'Entertale Partners') }}</title>
    <link rel="shortcut icon" href="{{ Request::root() }}/assets/img/favicon.ico" />

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

    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/datetimepicker/jquery.datetimepicker.css"/>
    <link href="/assets/plugins/jquery-notifications/css/messenger.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/jquery-notifications/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script>
        baseurl = "<?php echo env('APP_URL');?>";
    </script>
</head>
<body>

<!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid">

        @include('admin.leftmenu')

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




<?php use App\Http\Controllers\StudioSettingsController;

$ppEmailRes = StudioSettingsController::check_pp_email(); ?>

@if(!$ppEmailRes)
    @if(Auth::user()->role == 2)
        <div class="top-notif-studio">
            <h3 class="">Enter your PayPal E-mail</h3>
            <p class="">E-mail is necessary for payment</p>
            <form action="/studio/settings/addemail" method="post">
                {{csrf_field()}}
                <input type="email" name="email" style="min-height: 40px;" required>
                <input class="btn btn-danger" type="submit" name="submit" value="Accept">
                <button class="close-top-notif-studio btn btn-danger" type="button">Not now</button>
            </form>
        </div>
    @endif
@endif


    <!-- BEGIN JS DEPENDECENCIES-->
{{--    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>--}}
    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-3.2.0.min.js" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    <script src="{{ Request::root() }}/assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>

    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

    <script>

        if(typeof $('#adminusertb') != 'undefined'){
            $(document).ready(function(){
                $('#adminusertb').DataTable();
            });
        }

        if(typeof $('#adminmoviestv') != 'undefined'){
            $(document).ready(function(){
                $('#adminmoviestv').DataTable();
            });
        }

    </script>


    <script src="{{ Request::root() }}/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

    <!-- END CORE JS DEPENDECENCIES-->

    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{ Request::root() }}/bami/js/bami.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/js/custom_admin.js" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ Request::root() }}/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ Request::root() }}/assets/js/form_elements.js" type="text/javascript"></script>





</body>
</html>
