@extends('layouts.playSolo')



@section('content')

    <div class="col-md-8 col-md-offset-2 m-t-50 no-padding" data-ng-controller="PlayController" data-ng-init="startVideo()" style="background-color:#000;">


            <div class="ng-cloak" data-ng-show="videoReady">

                <div id="videoPlayer" class="text-center">

                </div>

            </div>



    </div>

@endsection

