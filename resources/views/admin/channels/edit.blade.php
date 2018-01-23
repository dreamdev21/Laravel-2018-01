@extends('admin.king')

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'link code'
    });
</script>

@section('content')

    <div class="col-md-8 col-md-offset-2 m-t-50">
        <div class="col-md-12 entry-content">
            <form action="{{ route('channels.update', $channel->id) }}" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="ch_num" class="label">Channel Number</label>
                    <input type="number" class="form-control" name="ch_num" value="{{ $channel->ch_num }}" id="ch_num">
                </div>
                <div class="form-group">
                    <label class="label" for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $channel->title }}" />

                    @if($errors->has('title'))
                        <div class="log log--error">{{ $errors->first('title') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="label" for="description">Description</label>
                    <textarea name="description" class="form-control" id="description">{{ $channel->description }}</textarea>
                    {{--@if($errors->has('description))--}}
                    {{--<div class="log log--error">{{ $errors->first('description') }}</div>--}}
                    {{--@endif--}}
                </div>

                <div class="m-t-40">
                    <p>
                        <a href="{{ route('channels.show', array($channel->id)) }}" class="btn btn-xs btn-danger"><span class="fa fa-edit"></span> CANCEL</a>
                        <button type="submit" class="btn btn-xs btn-success">UPDATE</button>
                    </p>

                </div>

            </form>



        </div>

@endsection
