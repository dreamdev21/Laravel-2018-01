@extends('admin.king')

@section('content')

    <div class="col-md-8 col-md-offset-2 m-t-50">
        <div class="col-md-9 entry-content">
            <div class="col-md-4">

                    <div>
                        <img src="{{ asset('assets/images/' . $movie->poster) }}"  class="img-responsive" alt=""/>
                    </div>

            </div>

            <div class="col-md-8">
                <h1>{{ $movie->title }}</h1>
                <h4>Created At: <span class="bold">{{ date('F j, Y', strtotime($movie->created_at)) }}</span></h4>
                <p class="m-t-20"> {!! $movie->description !!} </p>
            </div>
        </div>


        <div class="col-md-3 m-t-40">
            <p>
                URL Slug:<br>
                <span><a href="{{ url('movies/' . $movie->slug) }}">{{ url('movies/' . $movie->slug) }}</a></span>

            </p>
            <br>
            <p>
                <a href="{{ route('movies.edit', array($movie->id)) }}" class="btn btn-xs btn-danger btn-block"> EDIT</a>

                {!! Form::open(array('route' => array('movies.destroy', $movie->id), 'method' => 'DELETE')) !!}
                {!! Form::submit('DELETE', ['class' => 'btn btn-success btn-block']) !!}
                {!! Form::close() !!}

            </p>

        </div>

    </div>

@endsection