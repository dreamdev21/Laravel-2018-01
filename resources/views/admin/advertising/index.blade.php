@extends('admin.king')

@section('content')

    <div class="row ads_add_banner_ads_area_hidden" style="overflow: hidden">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title no-border">
                    <h4 class="ads_add_banner_ads_area">Live TV <span class="semi-bold">Right banner</span></h4>
                </div>
                <div class="grid-body no-border" style="display: block;">
                    <br>
                    <form action="{{ route('create_banner_ads') }}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-8 col-sm-8 col-xs-8">

                                <div class="radio radio-success">

                                    @if($banner_ads->type == 'banner')

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="ads_type_radio" id="yes" type="radio" name="ads_type" value="banner" checked>
                                        <label for="yes">Image Banner</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="ads_type_radio" id="no" type="radio" name="ads_type" value="google">
                                        <label for="no">Google ads</label>
                                    </div>

                                    @else

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="ads_type_radio" id="yes" type="radio" name="ads_type" value="banner">
                                        <label for="yes">Image Banner</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="ads_type_radio" id="no" type="radio" name="ads_type" value="google" checked>
                                        <label for="no">Google ads</label>
                                    </div>

                                    @endif
                                </div>

                            </div>


                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_banner"
                                 @if($banner_ads->type == 'google')
                                 style="opacity: 0.1
                                 @endif
                            ">

                                {{csrf_field()}}
                                <div class="form-group">
                                    <label class="form-label">Link</label>
                                    <span class="help">https://www.google.com</span>
                                    <div class="controls">
                                        <input type="text" name="link" value="{{$banner_ads->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Link</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img" id="thumb_img" class="form-control">
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads->image)}}" width="150px" height="150px">
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google"
                                 @if($banner_ads->type == 'banner')
                                 style="opacity: 0.1
                            @endif
                            ">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label class="form-label">data-ad-client=" <b style="color: black;"> ca-pub-1234567898765432 </b> "</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="client" value="{{$banner_ads->client}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">data-ad-slot=" <b style="color: black;"> 1234567890 </b> "</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="slot" value="{{$banner_ads->slot}}" class="form-control">
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="controls">
                                        <button class="btn btn-danger" style="width: 100%">EDIT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row ads_add_banner_ads_area_hidden" style="overflow: hidden">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title no-border">
                    <h4 class="ads_add_banner_ads_area">News Page <span class="semi-bold">Top banner</span></h4>
                </div>
                <div class="grid-body no-border" style="display: block;">
                    <br>
                    <form action="{{ route('create_banner_ads_news1') }}" method="post" enctype="multipart/form-data">

                        <br>

                        <div class="row">

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label class="form-label">data-ad-client=" <b style="color: black;"> ca-pub-1234567898765432 </b> "</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="client" value="{{$banner_ads_news1->client}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">data-ad-slot=" <b style="color: black;"> 1234567890 </b> "</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="slot" value="{{$banner_ads_news1->slot}}" class="form-control">
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <button class="btn btn-danger" style="width: 100%">EDIT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row ads_add_banner_ads_area_hidden" style="overflow: hidden">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title no-border">
                    <h4 class="ads_add_banner_ads_area">User Page <span class="semi-bold">left menu banner</span></h4>
                </div>
                <div class="grid-body no-border" style="display: block;">
                    <br>
                    <form action="{{ route('create_banner_ads_left') }}" method="post" enctype="multipart/form-data">

                        <br>

                        <div class="row">

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Banner 1.1</h4>



                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub_yes" type="radio" name="left_pub" value="1"
                                        @if($banner_ads_left->public == 1)
                                            checked
                                        @endif
                                        >
                                        <label for="left_pub_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub_no" type="radio" name="left_pub" value="0"
                                        @if($banner_ads_left->public == 0)
                                        checked
                                        @endif
                                        >
                                        <label for="left_pub_no">Hide</label>
                                    </div>
                                </div>




                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title" value="{{$banner_ads_left->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description" value="{{$banner_ads_left->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Url</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url" value="{{$banner_ads_left->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img" id="thumb_img" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_left->image)}}" width="150px" height="150px">
                                </div>


                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Banner 1.2</h4>



                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left1_2_pub_yes" type="radio" name="left1_2_pub" value="1"
                                               @if($banner_ads_left1_2->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="left1_2_pub_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left1_2_pub_no" type="radio" name="left1_2_pub" value="0"
                                               @if($banner_ads_left1_2->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="left1_2_pub_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title1_2" value="{{$banner_ads_left1_2->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description1_2" value="{{$banner_ads_left1_2->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Url</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url1_2" value="{{$banner_ads_left1_2->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img1_2" id="thumb_img1_2" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_left1_2->image)}}" width="150px" height="150px">
                                </div>


                            </div>


                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Banner 2.1</h4>
                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub2_yes" type="radio" name="left_pub2" value="1"
                                        @if($banner_ads_left2->public == 1)
                                        checked
                                        @endif
                                        >
                                        <label for="left_pub2_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub2_no" type="radio" name="left_pub2" value="0"
                                        @if($banner_ads_left2->public == 0)
                                        checked
                                        @endif
                                        >
                                        <label for="left_pub2_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title2" value="{{$banner_ads_left2->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description2" value="{{$banner_ads_left2->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Url</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url2" value="{{$banner_ads_left2->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img2" id="thumb_img" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_left2->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2">
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Banner 2.2</h4>
                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub2_2_yes" type="radio" name="left_pub2_2" value="1"
                                               @if($banner_ads_left2_2->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="left_pub2_2_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub2_2_no" type="radio" name="left_pub2_2" value="0"
                                               @if($banner_ads_left2_2->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="left_pub2_2_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title2_2" value="{{$banner_ads_left2_2->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description2_2" value="{{$banner_ads_left2_2->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Url</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url2_2" value="{{$banner_ads_left2_2->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img2_2" id="thumb_img2_2" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_left2_2->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Banner 3.1</h4>
                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub3_yes" type="radio" name="left_pub3" value="1"
                                               @if($banner_ads_left3->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="left_pub3_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub3_no" type="radio" name="left_pub3" value="0"
                                               @if($banner_ads_left3->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="left_pub3_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title3" value="{{$banner_ads_left3->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description3" value="{{$banner_ads_left3->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Url</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url3" value="{{$banner_ads_left3->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img3" id="thumb_img3" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_left3->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2">
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Banner 3.2</h4>
                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub3_2_yes" type="radio" name="left_pub3_2" value="1"
                                               @if($banner_ads_left3_2->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="left_pub3_2_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="left_pub" id="left_pub3_2_no" type="radio" name="left_pub3_2" value="0"
                                               @if($banner_ads_left3_2->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="left_pub3_2_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title3_2" value="{{$banner_ads_left3_2->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description3_2" value="{{$banner_ads_left3_2->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Url</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url3_2" value="{{$banner_ads_left3_2->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img3_2" id="thumb_img3_2" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_left3_2->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <button class="btn btn-danger" style="width: 100%">EDIT</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row ads_add_banner_ads_area_hidden" style="overflow: hidden">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title no-border">
                    <h4 class="ads_add_banner_ads_area">User Page <span class="semi-bold">right menu banner</span></h4>
                </div>
                <div class="grid-body no-border" style="display: block;">
                    <br>
                    <form action="{{ route('create_banner_ads_right') }}" method="post" enctype="multipart/form-data">

                        <br>

                        <div class="row">

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Ads sponsored 1.1</h4>

                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right_pub_yes" type="radio" name="right_pub" value="1"
                                               @if($banner_ads_right->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="right_pub_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right_pub_no" type="radio" name="right_pub" value="0"
                                               @if($banner_ads_right->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="right_pub_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title" value="{{$banner_ads_right->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description" value="{{$banner_ads_right->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url" value="{{$banner_ads_right->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img" id="thumb_img" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                                <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Ads sponsored 1.2</h4>

                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right1_2_pub_yes" type="radio" name="right1_2_pub" value="1"
                                               @if($banner_ads_right1_2->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="right1_2_pub_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right1_2_pub_no" type="radio" name="right1_2_pub" value="0"
                                               @if($banner_ads_right1_2->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="right1_2_pub_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title1_2" value="{{$banner_ads_right1_2->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description1_2" value="{{$banner_ads_right1_2->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url1_2" value="{{$banner_ads_right1_2->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img1_2" id="thumb_img1_2" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right1_2->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Ads sponsored 1.3</h4>

                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right1_3_pub_yes" type="radio" name="right1_3_pub" value="1"
                                               @if($banner_ads_right1_3->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="right1_3_pub_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right1_3_pub_no" type="radio" name="right1_3_pub" value="0"
                                               @if($banner_ads_right1_3->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="right1_3_pub_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title1_3" value="{{$banner_ads_right1_3->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description1_3" value="{{$banner_ads_right1_3->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url1_3" value="{{$banner_ads_right1_3->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img1_3" id="thumb_img1_3" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right1_3->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Ads sponsored 2.1</h4>
                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub2" id="right_pub2_yes" type="radio" name="right_pub2" value="1"
                                               @if($banner_ads_right2->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="right_pub2_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub2" id="right_pub2_no" type="radio" name="right_pub2" value="0"
                                               @if($banner_ads_right2->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="right_pub2_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title2" value="{{$banner_ads_right2->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description2" value="{{$banner_ads_right2->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url2" value="{{$banner_ads_right2->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img2" id="thumb_img" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right2->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                    {{csrf_field()}}
                                    <h4>Ads sponsored 2.2</h4>

                                    <div class="radio radio-success">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub" id="right2_2_pub_yes" type="radio" name="right2_2_pub" value="1"
                                                   @if($banner_ads_right2_2->public == 1)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right2_2_pub_yes">Show</label>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub" id="right2_2_pub_no" type="radio" name="right2_2_pub" value="0"
                                                   @if($banner_ads_right2_2->public == 0)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right2_2_pub_no">Hide</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="title2_2" value="{{$banner_ads_right2_2->title}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="description2_2" value="{{$banner_ads_right2_2->description}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">URL</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="url2_2" value="{{$banner_ads_right2_2->link}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <span class="help">jpg, jpeg, png, gif, </span>
                                        <div class="controls">
                                            <input type="file" name="img2_2" id="thumb_img2_2" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right2_2->image)}}" width="150px" height="150px">
                                    </div>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2"></div>

                            <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                {{csrf_field()}}
                                <h4>Ads sponsored 2.3</h4>

                                <div class="radio radio-success">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right2_3_pub_yes" type="radio" name="right2_3_pub" value="1"
                                               @if($banner_ads_right2_3->public == 1)
                                               checked
                                                @endif
                                        >
                                        <label for="right2_3_pub_yes">Show</label>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input class="right_pub" id="right2_3_pub_no" type="radio" name="right2_3_pub" value="0"
                                               @if($banner_ads_right2_3->public == 0)
                                               checked
                                                @endif
                                        >
                                        <label for="right2_3_pub_no">Hide</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="title2_3" value="{{$banner_ads_right2_3->title}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="description2_3" value="{{$banner_ads_right2_3->description}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <span class="help"></span>
                                    <div class="controls">
                                        <input type="text" name="url2_3" value="{{$banner_ads_right2_3->link}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <span class="help">jpg, jpeg, png, gif, </span>
                                    <div class="controls">
                                        <input type="file" name="img2_3" id="thumb_img2_3" class="form-control">
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right2_3->image)}}" width="150px" height="150px">
                                </div>
                            </div>

                            </div>
                        <br><br>
                        <br><br>

                            <div class="row">

                                <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                    {{csrf_field()}}
                                    <h4>Ads sponsored 3.1</h4>
                                    <div class="radio radio-success">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub3" id="right_pub3_yes" type="radio" name="right_pub3" value="1"
                                                   @if($banner_ads_right3->public == 1)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right_pub3_yes">Show</label>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub3" id="right_pub3_no" type="radio" name="right_pub3" value="0"
                                                   @if($banner_ads_right3->public == 0)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right_pub3_no">Hide</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="title3" value="{{$banner_ads_right3->title}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="description3" value="{{$banner_ads_right3->description}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">URL</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="url3" value="{{$banner_ads_right3->link}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <span class="help">jpg, jpeg, png, gif, </span>
                                        <div class="controls">
                                            <input type="file" name="img3" id="thumb_img" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right3->image)}}" width="150px" height="150px">
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-2"></div>

                                <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                    {{csrf_field()}}
                                    <h4>Ads sponsored 3.2</h4>

                                    <div class="radio radio-success">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub" id="right3_2_pub_yes" type="radio" name="right3_2_pub" value="1"
                                                   @if($banner_ads_right3_2->public == 1)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right3_2_pub_yes">Show</label>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub" id="right3_2_pub_no" type="radio" name="right3_2_pub" value="0"
                                                   @if($banner_ads_right3_2->public == 0)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right3_2_pub_no">Hide</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="title3_2" value="{{$banner_ads_right3_2->title}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="description3_2" value="{{$banner_ads_right3_2->description}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">URL</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="url3_2" value="{{$banner_ads_right3_2->link}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <span class="help">jpg, jpeg, png, gif, </span>
                                        <div class="controls">
                                            <input type="file" name="img3_2" id="thumb_img3_2" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right3_2->image)}}" width="150px" height="150px">
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-2"></div>

                                <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                    {{csrf_field()}}
                                    <h4>Ads sponsored 3.3</h4>

                                    <div class="radio radio-success">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub" id="right3_3_pub_yes" type="radio" name="right3_3_pub" value="1"
                                                   @if($banner_ads_right3_3->public == 1)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right3_3_pub_yes">Show</label>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <input class="right_pub" id="right3_3_pub_no" type="radio" name="right3_3_pub" value="0"
                                                   @if($banner_ads_right3_3->public == 0)
                                                   checked
                                                    @endif
                                            >
                                            <label for="right3_3_pub_no">Hide</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="title3_3" value="{{$banner_ads_right3_3->title}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="description3_3" value="{{$banner_ads_right3_3->description}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">URL</label>
                                        <span class="help"></span>
                                        <div class="controls">
                                            <input type="text" name="url3_3" value="{{$banner_ads_right3_3->link}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <span class="help">jpg, jpeg, png, gif, </span>
                                        <div class="controls">
                                            <input type="file" name="img3_3" id="thumb_img3_3" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$banner_ads_right3_3->image)}}" width="150px" height="150px">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4 ads_type_google">
                                </div>

                            </div>

                        <br>

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <button class="btn btn-danger" style="width: 100%">EDIT</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="panel panel-default">

            <h2 class="panel-heading">All Advertising</h2>
            <a href="{{ route('advertising.create') }}" type="button" class="btn btn-danger">Create new advertisement</a>

            <div class="panel-body">

                <table class="table table-striped table-flip-scroll cf">
                    <thead class="table-header">
                    <th>Advertising Name</th>
                    <th>Advertising Type</th>
                    <th>Link</th>
                    <th>ADS Video / mp4</th>
                    <th>SET/</th>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        <tr>

                            <td>
                                {{$ad->preroll_name}}
                            </td>

                            <td>
                                {{$ad->preroll_type}}
                            </td>

                            <td>
                                {{$ad->preroll_goto_link}}
                            </td>

                            <td>
                                @if($ad->preroll_type == 'preroll')
                                <video width="150" controls="controls" >
                                    <source src="{{ \Storage::disk('s3frenvid')->url('ads/videos/'.$ad->preroll_mp4)}}" type='video/mp4;'>
                                </video>
                                @else
                                    <img src="{{ \Storage::disk('s3frenvid')->url('ads/images/'.$ad->preroll_thumbimg)}}" alt="" width="150px" height="100px">
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('advertising.edit', $ad->id)}}" class="btn btn-xs btn-danger">Edit</a>
                                <div style="display: inline-block;">
                                    {!! Form::open(array('route' => array('advertising.destroy', $ad->id), 'method' => 'DELETE')) !!}
                                    {!! Form::submit('DELETE', ['class' => 'btn btn-success btn-xs']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
