@extends('admin.king')


@section('content')
    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
    <style>
        .sub-block{
            border: 2px solid #bbb;
            width: 200px;
            margin-top: 5px;
        }
        .sub-block p{
            background: #ddd;
            text-align: center;
            font-size: 18px;
            margin-bottom: 0;
        }
        .sub-body-basic{
            padding: 25px 0;
            background: #008ac5;
        }
        .sub-body-pro{
            padding: 25px 0;
            background: #00b540;
        }
        .sub-body-pro h2{
            color: white;
            font-weight: bolder;
        }
        .sub-body-basic h2{
            color: white;
            font-weight: bolder;
        }
        input[type=radio]{
            display: block;
            margin: 5px auto;
        }
    </style>

    <div class="payment">
        <h4 class="text-center" style="margin-bottom: 10px;">Please choose subscription plan for start using TV station functionality</h4>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form id="form-pay" method="post" action="{{ route('rented') }} ">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="row" style="margin-left: 100px; margin-top: 50px;">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="sub-block">
                                    <div>
                                        <p>{{$basic->name}} Tv user</p>
                                        <div class="sub-body-basic">
                                            <h2 class="text-center">{{$basic->amount}}$</h2>
                                        </div>
                                    </div>
                                    <div><input type="radio" name="subscription" value="basic"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="sub-block">
                                    <div>
                                        <p>{{$pro->name}} Tv user</p>
                                        <div class="sub-body-pro">
                                            <h2 class="text-center">{{$pro->amount}}$</h2>
                                        </div>
                                    </div>
                                    <div><input type="radio" name="subscription" value="pro"></div>
                                </div>
                            </div>
                            @if(!$trial_used)
                                <div class="col-md-3">
                                    <div class="sub-block" style="border: 2px solid #bbb;">
                                        <div>
                                            <p>Try free trial</p>
                                            <div class="sub-body-basic" style="background: #c7a527">
                                                <h2 class="text-center">1 Week</h2>
                                            </div>
                                        </div>
                                        <div><button class="btn btn-success btn-block" id="trialBtn" style="height: 23px; padding-top: 3px;">Start trial</button></div>
                                    </div>
                                    <div>
                                        <p class="hidden" id="trial_error">You can't use trial anymore</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="hidden" id="payment">
                        <div id="payments"></div>
                        <input id="amount" name="amount" type="hidden" min="1"  value="">
                        <input name="cd__36698__1WWWm" type="hidden" min="1"  value="">
                        <p class="hidden" id="payment_error" style="color: red">Your payment information is incorrect</p>
                        <div class="modal-footer m-t-10" style="background-color:#e5e9ec; border-top:0 solid #333; padding: 0;">
                            <div style="text-align:center;">
                                <button id="submitButton" value="" name="submit" type="submit" class="btn btn-danger">Pay Subscription </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--<div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="sub-block" style="border: 2px solid #bbb;">--}}
                    {{--<div>--}}
                        {{--<p>Try free trial</p>--}}
                        {{--<div class="sub-body-basic" style="background: #c7a527">--}}
                            {{--<h2 class="text-center">1 Week</h2>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div><button class="btn btn-success btn-block">Start trial</button></div>--}}
                {{--</div>--}}
                {{--<div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <script src="https://js.braintreegateway.com/v2/braintree.js"></script>


    <script>
        $( document ).ready(function() {
            braintree.setup('{{ Braintree_ClientToken::generate() }}', "dropin", {
                container: "payments",
                singleUse: false,
                onPaymentMethodReceived: function (data) {
                    $('#payment_error').addClass('hidden');
                    data.amount = $('input[name="subscription"]:checked').val() === 'pro' ? "{{$pro->amount}}" : "{{$basic->amount}}";
                    $.ajax({
                        type: 'post',
                        url: 'set_subscription',
                        data: {
                            'data': data,
                            '_token': Laravel.csrfToken
                        }, success: function (res) {
                            if(res === 'success') window.location.href = '/tv/videos';
                        }
                    });
                },
                onError: function (e) {
                    $('#payment_error').removeClass('hidden');
                    return false;
                }
            });

            $('input[name="subscription"]').on('change', function (e) {
                if(e.target.value === 'basic'){
                    $('#submitButton').text('Pay Subscription ({{$basic->amount}}$)');
                    $('input[name="cd__36698__1WWWm"]').val({{$basic->amount}});
                }
                if(e.target.value === 'pro'){
                    $('#submitButton').text('Pay Subscription ({{$pro->amount}}$)');
                    $('input[name="cd__36698__1WWWm"]').val({{$pro->amount}});
                }
                $('#payment').removeClass('hidden');
            });

            $('#trialBtn').on('click', function () {
                $.ajax({
                    type: 'get',
                    url: 'set_trial',
                    success: function(res){
                        if(res === 'success') window.location.href = '/tv/videos';
                        if(res === 'error') $('#trial_error').removeClass('hidden');
                    }
                });
            })
        });
    </script>
@endsection