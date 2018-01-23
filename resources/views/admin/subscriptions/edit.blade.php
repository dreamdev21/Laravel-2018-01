<form action="{{ route('edit_subscription') }}" method="post" enctype="multipart/form-data" id="a_form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <br>
        <i class="fa fa-credit-card fa-7x"></i>
        <h4 id="myModalLabel" class="semi-bold">Edit subscription</h4>
        <br>
    </div>
    <div class="modal-body">
        <div class="panel-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label class="form-label" name="title">Subscription name</label>
                <div class="controls">
                    <input type="text" name="name" id="name" value="{{ $subscription->name }}" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" name="url">Subscription amount</label>
                <div class="controls">
                    <input type="text" name="amount" id="amount" value="{{ $subscription->amount }}" class="form-control" required>
                    <p class="hidden" id="amount_error" style="color: red">Please enter correct amount</p>
                </div>
            </div>
            <input type="hidden" name="id" value="{{$subscription->id}}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script>
    $('#a_form').on('submit', function () {
        $('#amount_error').addClass('hidden');
        if(parseInt($('#amount').val()) <= 0){
            $('#amount_error').removeClass('hidden');
            return false;
        }
    });
</script>