
<!-- Modal -->
<div class="modal fade" id="soloModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog" style=" margin-top:100px">
        <div class="modal-content" style="max-width:500px !important;">
            <div class="modal-header" style=" border-bottom: 0px solid #e5e5e5; background-color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <br>
            </div>

            <div class="modal-body" style="background-color:#fff; padding-left:50px; padding-right:50px;">
                <div class="row form-row">
                    <div class="col-md-12 text-center">
                        <span style="font-size: 30px;">{{ $movies->title }}</span> <span>{{ $movies->year }}</span>

                    </div>


                    <div class="row">

                        <div class="col-md-12">
                            @if(Auth::user()->card_last_four && Auth::user()->braintree_token && Auth::user()->braintree_id)
                            <form method="post" action="{{ route('srented') }}">
                                {{ csrf_field() }}
                                <input id="amount" name="amount" type="hidden" min="1"  value="{{ $movies->price }}">
                                <input name="cd__36698__1WWWm" type="hidden" min="1"  value="{{ $movies->id }}">
                                <div class="modal-footer m-t-10" style="background-color:#fff; border-top:0px solid #333; padding: 0px;">
                                    <button id="submitButton" value="{{ $movies->price }}" name="submitsavepayment" type="submit" class="btn btn-danger btn-block">Select saved payment method: <b>************{{Auth::user()->card_last_four}}</b></button>
                                </div>
                            </form>
                            <hr>
                            @endif

                            <form id="form-pay" method="post" action="{{ route('rented') }} ">
                                {{ csrf_field() }}
                                <div id="payments"></div>

                                <input id="amount" name="amount" type="hidden" min="1"  value="{{ $movies->price }}">
                                <input name="cd__36698__1WWWm" type="hidden" min="1"  value="{{ $movies->id }}">

                                <p class="m-t-20">
                                    <input type="checkbox" name="save" class="m-r-10">
                                    Save this payment method for future use
                                </p>

                                <div class="modal-footer m-t-10" style="background-color:#fff; border-top:0px solid #333; padding: 0px;">
                                    <button id="submitButton" value="{{ $movies->price }}" name="submit" type="submit" class="btn btn-danger btn-block">RENT $ {{ $movies->price }} </button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">CANCEL</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>
<!-- /.modal-content -->

<script src="https://js.braintreegateway.com/v2/braintree.js"></script>


  <script>

      braintree.setup('{{ Braintree_ClientToken::generate() }}', "dropin", {
          container: "payments",
          singleUse: false,

      });

  </script>






