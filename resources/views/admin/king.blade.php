<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <title>{{ config('app.name', 'Entertale Admin') }}</title>
    <link rel="shortcut icon" href="{{ Request::root() }}/assets/img/favicon.ico" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="{{ Request::root() }}/general/css/admin.min.css" >

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
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery.form.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/raphael-min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-ricksaw-chart/js/d3.v2.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-ricksaw-chart/js/rickshaw.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-morris-chart/js/morris.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-easy-pie-chart/js/jquery.easypiechart.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-flot/jquery.flot.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-flot/jquery.flot.time.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-flot/jquery.flot.selection.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-flot/jquery.flot.animator.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-flot/jquery.flot.orderBars.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-sparkline/jquery-sparkline.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-easy-pie-chart/js/jquery.easypiechart.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery.dataTables.min.js"></script>--}}



    {{--<script src="{{ Request::root() }}/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>--}}
    {{--<script src="{{ Request::root() }}/bami/js/bami.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/js/custom_admin.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>--}}
    {{--<script src="{{ Request::root() }}/assets/js/form_elements.js" type="text/javascript"></script>--}}

@if(isset($dmctrue))
    <script src="{{ Request::root() }}/general/js/chart.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.js" type="text/javascript"></script>
@else
    <script src="{{ Request::root() }}/general/js/admin.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.js" type="text/javascript"></script>
@endif

@yield('javascript')

<script>




    if(typeof $('#chanDTable') != 'undefined'){
        $(document).ready(function(){
            $('#chanDTable').DataTable();
        });
    }


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

    if(typeof $('#adminseriestv') != 'undefined'){
        $(document).ready(function(){
            $('#adminseriestv').DataTable();
        });
    }

    if(typeof $('#vidstaion') != 'undefined'){
        $(document).ready(function(){
            $('#vidstaion').DataTable();
        });
    }




</script>



@if(isset($monthly_sales) && count($monthly_sales) > 1)
<script>
    $(document).ready(function() {

        var studio_chart = Morris.Line({
            element: 'studio-chart',
            data: [
                @foreach($monthly_sales as $ms_key => $ms)
                { y: '{{$ms_key}}', a: '{{$ms}}' },
                @endforeach
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['$'],
            lineColors:['#0aa699']
        });

        if(typeof $('#chart_dp') != 'undefined'){

            $('#chart_dp').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true
            });

            $('#chart_dp').on('change', function () {

                var date_dp = $(this).val();
                $.ajax({
                    type:'post',
                    dataType: 'json',
                    url:'/studio/get_chart_res',
                    data:{
                        date_dp: date_dp,
                        '_token':Laravel.csrfToken
                    },
                    success:function(res){

                        var data = [];

                        $.each(res, function (i, item) {
                            data.push({ y: i, a: item });
                        });

                        studio_chart.setData(data);
                    }
                })
            });

        }

    });
</script>
@endif

</body>
</html>
