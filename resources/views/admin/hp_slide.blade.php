@extends('admin.king')

@section('content')

    <div class="row">
        <div class="panel panel-default">
            <h2 class="panel-heading">Home Page Slider</h2>

            <div class="container">
            <div class="row ads_add_banner_ads_area_hidden" style="overflow: hidden; text-align: center;">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-title no-border">
                            <h4 class="ads_add_banner_ads_area"> Add New <span class="semi-bold">Image</span></h4>
                        </div>
                        <div class="grid-body no-border" style="display: block;">
                            <br>
                            <form action="/admin/add_hp_slide_image" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">

                                    <div class="col-md-4 col-md-offset-4 ads_type_banner">

                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="file" name="img" id="thumb_img" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="controls">
                                                <button class="btn btn-danger" style="width: 100%">ADD</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="panel-body text-center">
                @foreach($hpslider as $hps)
                <div class="ap_slide_image_cons">
                    <span class="del_hp_slide_image" id="{{$hps->id}}"> <i class="material-icons">highlight_off</i> </span>
                    <img src="/assets/images/{{$hps->img}}" class="img-responsive img-thumbnail" alt="Cinque Terre" style="height: 200px;">
                </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
