@extends('admin.king')

@section('content')

    <div class="col-md-8 col-md-offset-2 m-t-50">
        <div class="col-md-9 entry-content">

            <h1>{{ $channel->title }}</h1>
            <h4>Created At:</h4>
            <span class="bold">{{ date('F j, Y', strtotime($channel->created_at)) }}</span>
            <p class="m-t-20"> {!! $channel->description !!} </p>

            <div>
                <h3># {{$channel->ch_num}}</h3>
            </div>
        </div>


        <div class="col-md-3 m-t-40">
            <p>
                <a href="{{ route('channels.edit', array($channel->id)) }}" class="btn btn-xs btn-danger btn-block"> EDIT</a>

                {!! Form::open(array('route' => array('channels.destroy', $channel->id), 'method' => 'DELETE')) !!}
                {!! Form::submit('DELETE', ['class' => 'btn btn-success btn-block']) !!}
                {!! Form::close() !!}

            </p>
        </div>

    </div>

@endsection