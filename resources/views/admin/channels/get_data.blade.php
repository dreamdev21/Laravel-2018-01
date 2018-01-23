@extends('admin.king')

@section('content')
    <div class="">
        <input type="text" placeholder="Channel Url" class="form-control get_v_data pull-left" style="width: 70%; margin-right: 10px"/>
        <button type="button" class="btn btn-lg btn-danger get_channel_data">Get Data</button>
        {{--<a href="/admin/channels" type="button" class="btn btn-primary">CHANNELS</a>--}}
        <img src="{{ asset('assets/images/loading.gif') }}"  style="max-width: 33px; display: none" class="loading_gif"/>

        {{csrf_field()}}
    </div>

    <div>
    </div>
    <div class="row channel_all_data">
    </div>


@endsection
