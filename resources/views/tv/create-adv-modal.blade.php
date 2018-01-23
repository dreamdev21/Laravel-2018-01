<style>
    .ad-duration{
        border: 2px solid #ddd;
        border-radius: 4px;
        background: white;
        margin: 4px;
    }
    .ad-duration h3{
        font-size: 20px;
        font-weight: 400;
    }
    .ad-duration h4{
        margin-left: -5px;
    }
    input[type=radio]{
        display: block;
        margin: 0 auto 5px auto;
    }
</style>
<form action="{{ route('tvAd_save') }}" method="post" enctype="multipart/form-data" id="create-form">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <br>
    <i class="fa fa-credit-card fa-7x"></i>
    <h4 id="myModalLabel" class="semi-bold">Add Advertisement</h4>
    <br>
</div>
<div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-body create_ads_preroll">
                {{ csrf_field() }}


                {{--PREROLL AD BLOCK--}}

                <div class="grid simple bg-info" style="background: transparent">

                    <div class="form-group">
                        <label class="form-label" name="preroll_name">Name</label>
                        <div class="controls">
                            <input type="text" name="preroll_name" id="preroll_name" class="form-control" placeholder="Name">
                            <p style="color: red" class="hidden" id="error_name">This field cannot be empty</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" name="preroll_goto_link">Link</label>
                        <div class="controls">
                            <input type="text" name="preroll_goto_link" id="preroll_goto_link" class="form-control" placeholder="http://example.com/">
                            <p style="color: red" class="hidden" id="error_link">This field cannot be empty</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" name="preroll_skip_timer">Preroll Skip Timer / sec</label>
                        <div class="controls">
                            <input type="number" name="preroll_skip_timer" id="preroll_skip_timer" class="form-control">
                            <p style="color: red" class="hidden" id="error_time">This field cannot be empty</p>
                        </div>
                    </div>

                    @if($subscription === 'pro')
                        <div class="form-group">
                            <label class="form-label" name="preroll_mp4">ADS Video / mp4</label>
                            <div class="controls">
                                <input type="file" name="preroll_mp4" id="preroll_mp4" class="form-control">
                            </div>
                        </div>
                    @endif

                    @if($subscription !== 'pro')
                        <div class="form-group">
                            <label class="form-label" name="preroll_goto_link">Advertising url</label>
                            <div class="controls">
                                <input type="text" name="url" id="url" class="form-control" placeholder="http://example.com/">
                                <p style="color: red" class="hidden" id="error_url">This field cannot be empty</p>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label" name="thumb_img">Thumb Img</label>
                        <div class="controls">
                            <input type="file" name="thumb_img" id="thumb_img" class="form-control">
                            <p style="color: red" class="hidden" id="error_image">This field cannot be empty</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Advertising duration</label>
                        <div class="row" style="margin: 0 auto">
                            <div class="col-md-1" style="margin-left: 20px;"></div>
                            <div class="col-md-2 ad-duration">
                                <h3 class="text-center">1 week</h3>
                                <h4 class="text-center">100$</h4>
                                <div><input type="radio" class="ad-radio" name="adv_duration" value="100"></div>
                            </div>
                            <div class="col-md-2 ad-duration">
                                <h3 class="text-center">2 weeks</h3>
                                <h4 class="text-center">200$</h4>
                                <div><input type="radio" class="ad-radio" name="adv_duration" value="200"></div>
                            </div>
                            <div class="col-md-2 ad-duration">
                                <h3 class="text-center">1 month</h3>
                                <h4 class="text-center">1000$</h4>
                                <div><input type="radio" class="ad-radio" name="adv_duration" value="1000"></div>
                            </div>
                            <div class="col-md-2 ad-duration">
                                <h3 class="text-center">3 months</h3>
                                <h4 class="text-center">2000$</h4>
                                <div><input type="radio" class="ad-radio" name="adv_duration" value="2000"></div>
                            </div>
                        </div>
                        <p style="color: red" class="hidden" id="duration_error">Please choose duration</p>
                    </div>

                    <div class="add-adv" style="display: none">
                        <span class="ad-title">
                            <label for="ad"></label>
                            <input type="text" class="ad-title-inp" value="">
                        </span>
                    </div>

                    <div id="payment" class="hidden">
                        @if(Auth::user()->card_last_four && Auth::user()->braintree_token && Auth::user()->braintree_id)
                                <input id="amount" name="amount" type="hidden" min="1"  value="">
                                <input name="cd__36898__1WWWm" type="hidden" min="1"  value="">
                                <div class="modal-footer m-t-10" style="background-color:#fff; border-top:0px solid #333; padding: 0px;">
                                    <button id="submitButton" value="" name="submitsavepayment" type="submit" class="btn btn-danger btn-block">Select saved payment method: <b>************{{Auth::user()->card_last_four}}</b></button>
                                </div>
                            <hr>
                        @endif
                            <div id="payments"></div>
                            <input id="amount" name="amount" type="hidden" min="1"  value="">
                            <input name="cd__36698__1WWWm" type="hidden" min="1"  value="">
                            <p class="m-t-20">
                                <input type="checkbox" name="save" class="m-r-10">
                                Save this payment method for future use
                            </p>
                    </div>
                </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <!-- END HTML5 WYS5646456IWG CONTROLS-->
    <div class="col-md-12 m-b-50 text-center">
        <button type="submit" class="btn btn-lg btn-success"> Add new advertisement </button>
        <input type="hidden" name="_token" value="{{ Session::token() }}" />
    </div>
</div>
</form>
<script>
    $('form#create-form').submit(function () {
        if($('input[name="preroll_name"]').val() === ""){
            hide();
            $('#error_name').removeClass('hidden');
            return false;
        }
        if($('input[name="preroll_goto_link"]').val() === ""){
            hide();
            $('#error_link').removeClass('hidden');
            return false;
        }
        if($('input[name="preroll_skip_timer"]').val() === ""){
            hide();
            $('#error_time').removeClass('hidden');
            return false;
        }
        if($('input[name="thumb_img"]').val() === ""){
            hide();
            $('#error_image').removeClass('hidden');
            return false;
        }
        hide();
    });

    var hide = function () {
        $('#error_name').addClass('hidden');
        $('#error_link').addClass('hidden');
        $('#error_time').addClass('hidden');
        $('#error_video').addClass('hidden');
        $('#error_image').addClass('hidden');
        $('#duration_error').addClass('hidden');
    };

    var state = 'unpaid';
    $('#create-form').on('submit', function (e) {
        $('#duration_error').addClass('hidden');
        var status = $('#payment').attr('class');

        if(status === 'hidden'){
            var selected = parseInt($('input[name="adv_duration"]:checked').val());
            console.log(selected);
            if(selected !== 100 && selected !== 200 && selected !== 1000 && selected !== 2000 && !isNaN(selected)) alert('something goes wrong, please update page');
            if(isNaN(selected)){
                $('#duration_error').removeClass('hidden');
                return false;
            }
            braintree.setup('{{ Braintree_ClientToken::generate() }}', "dropin", {
                container: "payments",
                singleUse: false,
                onError: function (e) {
                    state = 'error';
                    return false;
                }
            });
            $('#payment').removeClass('hidden');
            return false;
        }
        else{
            setTimeout(function () {
                if(state === 'unpaid' || state === 'error') return false;
            }, 1000);
        }
    });

    $('input[name="adv_duration"]').on('change', function (e) {
        $('input[name="amount"]').val(e.target.value);
    })
</script>
