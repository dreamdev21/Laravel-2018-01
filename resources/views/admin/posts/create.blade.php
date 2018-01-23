@extends('admin.king')

<script src="{{ Request::root() }}/tinymce/tinymce.min.js"></script>


<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'link code media link image lists hr anchor ' +
        'pagebreak nonbreaking print preview template textpattern' +
        'paste table contextmenu textcolor insertdatetime'

    });
</script>

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Create Posts</h2>

                <div class="panel-body">
                    
                         <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label class="form-label" name="title">Title</label>
                                        <div class="controls">
                                            <input type="text" name="title" id="title" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" name="category_id">Select Category</label>
                                            <select class="full-width" name="category_id" >

                                               @foreach ($postCategories as $postCategory)

                                                    <option value="{{$postCategory->id}}">{{$postCategory->name}}</option>

                                                @endforeach
                                                 
                                            </select>

                                    </div>



                                    <div class="form-group">
                                        <div class="grid simple">
                                            <div class="grid-title no-border">
                                                <h4>Post <span class="semi-bold">Image</span></h4>
                                            </div>
                                            <div class="grid-body no-border">
                                                <div class="row-fluid">
                                                        <div class="fallback">
                                                            <input name="image" type="file"  />
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="form-group">
                                         <label class="form-label" name="video">Video</label>
                                         <div class="controls">
                                             <input type="text" name="video" id="video" placeholder="https://www.youtube.com/watch?v=n0SQv2zs9hQ" class="form-control">
                                         </div>
                                     </div>

                                    <br/>


                                    <!-- BEGIN HTML5 WYSIWG CONTROLS-->

                                    <div class="form-group">
                                        <div class="grid simple">

                                            <div class="grid-body no-border">
                                                <h3>Post <span class="semi-bold">Content</span></h3>
                                                <textarea id="body" name="body" placeholder="Enter text ..." class="form-control" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                 <div class="col-sm-6">
                                     <label class="form-label" name="video">News tags</label>
                                     <div class="bootstrap-tagsinput" style="background: #fff">
                                        <input name="tags" type="text" class="form-control" data-role="tagsinput" value="" style="display: none;">
                                     </div>
                                     <hr>
                                 </div>

                                <!-- END HTML5 WYSIWG CONTROLS-->
                                <div class="col-md-12 m-b-50">
                                    <button type ="submit" class="btn btn-lg btn-success"> Add new post </button>
                                    <input type="hidden" name="_token" value="{{ Session::token() }}" />
                                </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
