<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <br>
    <i class="fa fa-credit-card fa-7x"></i>
    <h4 id="myModalLabel" class="semi-bold">Remove advertising</h4>
    <br>
</div>
<div class="modal-body">
    <div class="panel-body">
        <p>Are you sure you want to remove "<b>{{$ads->preroll_name}}</b>"?</p>
    </div>
</div>
<div class="modal-footer">
    {!! Form::open(array('route' => array('tvAdvertisingDelete', $ads->id), 'method' => 'DELETE')) !!}
    {!! Form::submit('DELETE', ['class' => 'btn btn-success btn-xs']) !!}
    {!! Form::close() !!}
</div>