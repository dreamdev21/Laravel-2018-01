@extends('admin.king')

@section('content')

        <div class="col-md-8 col-md-offset-2 m-t-50">
                <div class="col-md-9 entry-content">

                    <h1>{{ $post->title }}</h1>
                    <h4>Created At:</h4>
                    <span class="bold">{{ date('F j, Y', strtotime($post->created_at)) }}</span>

                    <div>
                        <img src="{{ asset('assets/images/' . $post->image) }}"  class="img-responsive" alt=""/>
                    </div>

                    <p class="m-t-20"> {!! $post->body !!} </p>
                </div>


                <div class="col-md-3 m-t-40">
                    <p>
                        URL Slug:<br>
                        <span><a href="{{ url('blog/' . $post->slug) }}">{{ url('blog/' . $post->slug) }}</a></span>

                    </p>
                    <br>
                    <p>
                        <a href="{{ route('posts.edit', array($post->id)) }}" class="btn btn-xs btn-danger btn-block"> EDIT</a>

                        {!! Form::open(array('route' => array('posts.destroy', $post->id), 'method' => 'DELETE')) !!}
                        {!! Form::submit('DELETE', ['class' => 'btn btn-success btn-block']) !!}
                        {!! Form::close() !!}

                    </p>

                </div>

        </div>

@endsection