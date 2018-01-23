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


            <form action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label class="label" for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $post->title }}"/>

                    @if($errors->has('title'))
                        <div class="log log--error">{{ $errors->first('title') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="label" for="body">Text</label>
                    <textarea name="body" class="form-control" id="body">{{ $post->body }}</textarea>

                    @if($errors->has('body'))
                        <div class="log log--error">{{ $errors->first('body') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image" class="image">
                        <input type="file" class="form-control" name="image" id="image">
                        <input type="hidden" name="oldFilename" value="{{ $post->image }}">
                        <span class="image__text text--uppercase">Upload Image</span>
                    </label>

                    @if($errors->has('image'))
                        <div class="log log--error">{{ $errors->first('image') }}</div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-label" name="video">News tags</label>
                        <div class="bootstrap-tagsinput" style="background: #fff">
                            <input name="tags" type="text" class="form-control" data-role="tagsinput" value="{{ implode(',', $post->tags) }}"
                                   style="display: none;">
                        </div>
                        <hr>
                    </div>
                </div>


                <div class="m-t-40">
                    <p>
                        <a href="{{ route('posts.show', array($post->id)) }}" class="btn btn-xs btn-danger"><span
                                    class="fa fa-edit"></span> CANCEL</a>
                        <button type="submit" class="btn btn-xs btn-success">UPDATE</button>

                    </p>

                </div>

            </form>


        </div>
    </div>
@endsection
