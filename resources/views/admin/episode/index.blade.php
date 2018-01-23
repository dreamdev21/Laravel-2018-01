@extends('admin.king')

<style>
    .panel-default>.panel-heading {
        color: #333;
        background-color: #e5e9ec !important;
        border-color: #e5e9ec;
    }

    .panel-heading {
        padding: 10px 15px;
        border-bottom: 0px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }

</style>

@section('content')
    <div class="row">
        <div class="panel panel-default">

            <h2 class="panel-heading" style="background-color: none !important;">All Episodes
                <a href="{{ route('episodes.create') }}" type="button" class="btn btn-danger">Add a new episodes</a>
            </h2>

            <div class="panel-body">

                @foreach($episode->chunk(3) as $items)
                    <div class="row">
                        @foreach($items as $sode)
                            <div class="col-md-3">

                                <img src="{{ asset('assets/images/' .$sode->episode_thumbnail)}}" class="img-responsive m-b-5" alt="" />

                                <div class="title pull-left">{{ $sode->episode_name }}</div>
                                <div class="title pull-right">
                                    <a href="{{ route('episodes.edit' , $sode->id) }}"><i class="ti-pencil"></i>Edit</a>&nbsp;&nbsp; | &nbsp;&nbsp;
                                    <div style="display: inline-block;">
                                        {!! Form::open(array('route' => array('episodes.destroy', $sode->id), 'method' => 'DELETE')) !!}
                                        {!! Form::submit('DELETE') !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>

                            </div>

                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
