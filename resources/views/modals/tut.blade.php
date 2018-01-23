<style>
    .add-payment-method-view .payment-container {
        background: none !important;
        background: none !important;
    }
</style>



<!-- Modal -->
<div class="modal fade" id="tut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style=" margin-top:100px">
        <div class="modal-content">
            <div class="modal-header" style=" border-bottom: 0px solid #e5e5e5; background-color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <br>
            </div>

            <div class="modal-body" style="background-color:#fff; padding-left:50px; padding-right:50px;">
                <div class="row form-row">
                    <div class="col-md-12 text-center">
                        <span style="font-size: 30px;">The Wolf of Wall Street</span> <span>2013</span>

                    </div>


                    <div class="row">

                        <div class="col-md-12">



                                <div class="modal-footer m-t-10" style="background-color:#fff; border-top:0px solid #333; padding: 0px;">
                                    <button id="submitButton" name="submit" type="submit" class="btn btn-danger btn-block">RENT $ {{ $movie->price }} </button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">CANCEL</button>
                                </div>


                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>
<!-- /.modal-content -->











