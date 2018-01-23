@extends('admin.king')

@section('content')

    <div class="row ads_add_banner_ads_area_hidden" style="overflow: hidden">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title no-border">
                    <h4 class="ads_add_banner_ads_area">Live TV <span class="semi-bold">Slider</span></h4>
                </div>
                <div class="grid-body no-border" style="display: block;">
                    <br>

                    <div class="col-md-5">

                        <table class="table table-striped table-flip-scroll cf">
                            <thead class="table-header">
                                <th>Poster</th>
                                <th>TV Title</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Slider</th>
                            </thead>
                            <tbody>
                            @foreach($vidarr as $vid)
                                <tr>
                                    <td>
                                        <img style="width: 100px;" src="https://img.youtube.com/vi/{{$vid->video_id}}/hqdefault.jpg" alt="">
                                    </td>
                                    <td>
                                       {{$vid->title}}
                                    </td>

                                    <td>
                                        <input class="slide_text_{{$vid->id}}" type="text" value="{{$vid->slide_title}}">
                                    </td>

                                    <td>
                                        <input class="slide_desc_{{$vid->id}}" type="text" value="{{$vid->slide_desc}}">
                                    </td>

                                    <td>

                                        <div class="radio radio-success">
                                            <input class="subm_news_slide_img" data-vidid="{{$vid->id}}" id="yes_{{$vid->id}}" type="radio" name="optionyes_{{$vid->id}}" value="1"
                                                @if($vid->slide_public == 1)
                                                checked
                                                @endif
                                            >
                                            <label for="yes_{{$vid->id}}">Agree</label>

                                            <input class="subm_news_slide_img" data-vidid="{{$vid->id}}" id="no_{{$vid->id}}" type="radio" name="optionyes_{{$vid->id}}" value="0"
                                               @if($vid->slide_public == 0)
                                               checked
                                               @endif
                                            >
                                            <label for="no_{{$vid->id}}">Disagree</label>
                                        </div>

                                    </td>
                                </tr>
                                <br>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <a href="/admin/movieslide" type="button" class="btn btn-danger">Movie slider</a>

    <div class="row">
            <div class="panel panel-default">
                <h2 class="panel-heading">All Posts</h2>
                <a href="{{ route('posts.create') }}" type="button" class="btn btn-danger">Create new post</a>

                <a href="/admin/postscategory" type="button" class="btn btn-danger">Post Category</a>

                <div class="panel-body">
                    
                         <table class="table table-striped table-flip-scroll cf">
                            <thead class="table-header">
                                <th>#</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Created Date</th>
                                <th>image</th>
                                <th>Actions</th>
                            </thead>
                                    <tbody>
                                       @foreach ($posts as $post)
                                            <tr>
                                                <td>
                                                    {{ $post->id }}
                                                </td>
                                                <td style="width:20%">
                                                    {{ $post->title }}
                                                </td>
                                                <td valign="bottom">
                                                    <p>
                                                        {{ substr(strip_tags($post->body), 0, 50 ) }}{{ strlen(strip_tags($post->body)) > 50 ? "..." : ""  }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ date('F j, Y', strtotime( $post->created_at)) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <img src="{{ asset('assets/images/' . $post->image) }}" width="100px" hieght="100px" class="img-responsive" alt=""/>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-xs btn-danger"> Edit</a>
                                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-xs btn-success delete"> View</a>

                                                    </p>
                                                </td>
                                            </tr>
                                            @endforeach
                                        
                                   </tbody>
                            </table>
                            <div class="text-center">
                                {!! $posts->links() !!}
                             </div>
                </div>
            </div>
        </div>


@endsection
