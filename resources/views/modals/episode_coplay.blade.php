<!-- Modal -->
<div class="modal fade" id="coModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <br>
                <h4 id="myModalLabel" class="semi-bold">Select friends & send invites</h4>
                <div class="form-group">
                    <input class="coplay_search typeahead form-control sample-typehead" type="text" placeholder="Pick your friends">
                </div>
                <span class="inv_count_coplay"> is left {{4-$coplay_inv_count_res}} invitation </span>
            </div>
            <div class="modal-body">
                <div class="row form-row">

                    <div class="col-md-12 copay_search_area">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block send_coplay_inv" data-cophr="/movies/{{$episode->slug}}/play">Send Invites</button>
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->