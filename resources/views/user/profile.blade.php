@extends('layouts.queen')

@section('content')
    <?php use App\Http\Controllers\FollowerController;
    $fol_res = FollowerController::chat_res();?>
		<div class="row">

			<div class="col-md-8 col-md-offset-2">
				<div class=" tiles white col-md-12 no-padding">
					<div class="tiles green cover-pic-wrapper">
						<div class="overlayer bottom-right">
							<div class="overlayer-wrapper">
								<div class="padding-10 hidden-xs">

									@if (Auth::user()->isNot($user))
										@if($user->role != 1)
											@if (Auth::user()->isFollowing($user))
												<a style="color: white !important;" href="{{ route('users.unfollow', $user) }}" class="btn btn-primary btn-small">Unfollow</a>
											@else
												<a style="color: white !important;" href="{{ route('users.follow', $user) }}" class="btn btn-primary btn-small">Follow</a>
											@endif
										@endif
									@endif


									@if (!Auth::user()->isNot($user))
											<a style="color: white !important;" href="/users/{{$user->username}}/settings" class="btn btn-primary btn-small">Settings</a>
										<a style="color: white !important;" href="/followers/show" class="btn btn-primary btn-small">followers</a>
									@endif

								</div>
							</div>
						</div>
						@if (!Auth::user()->isNot($user))
						<div class="edit_cov">
							<img class="upload_up_image_cover" src="/assets/images/arrow-upload-icon.png" alt="" width="100" height="100"/>
							<p style="color: #040404;"><b>Change cover image</b></p>
							<form method="POST" action="{{ URL::to('/users/'. Auth::user()->username . '/settings/cover') }}" class="uscimg_form"  enctype="multipart/form-data" style="display: none;">
								{{ csrf_field() }}
								<input class="uscimg_inp" accept="image/*" required="true" name="cover" type="file" />
							</form>
						</div>
						@endif
						<img style="width: 100%; height: 250px; object-fit: cover;" src="/assets/images/{{$user->cover}}" alt="">
					</div>
					<div class="tiles white">
						<div class="row">
							<div class="col-md-3 col-sm-3">
								<div class="user-profile-pic">
									<img width="69" height="69" src="/assets/images/{{ $user->avatar }}" alt="">
								</div>
								<div class="user-mini-description">
									<h3 class="text-success semi-bold">
										{{$followers_res}}
									</h3>
									<h5>Followers</h5>
									<h3 class="text-success semi-bold">
										{{$following_res}}
									</h3>
									<h5>Following</h5>
								</div>
							</div>
							<div class="col-md-5 user-description-box  col-sm-5">
								<h4 class="semi-bold no-margin">{{ $user->username }}</h4>
								<br>
								<br>
								<br>
								@foreach($fol_res as $fr)
								@if($fr->id == $user->id)

								<p class="send_mess_f_u_p" id="{{$user->id}}"><i class="fa fa-envelope"></i>Send Message</p>

								@endif
								@endforeach
							</div>
							<div class="col-md-3  col-sm-3">
								<h5 class="normal">Friends ( <span class="text-success">{{count($all_fol_users)}}</span> )</h5>
								<ul class="my-friends">
									<?php $count_ap = 0; ?>
									@foreach($all_fol_users as $fuser)

									@if($count_ap >= 10)
									<li style="display:none;" class="us_hidden_av">
										<div class="profile-pic">
											<img width="35" height="35" src="/assets/images/{{$fuser->avatar}}" alt="">
										</div>
									</li>

									@else
									<li>
										<div class="profile-pic">
											<img width="35" height="35" src="/assets/images/{{$fuser->avatar}}" alt="">
										</div>
									</li>
									@endif

									<?php $count_ap++; ?>
									@endforeach

									@if($count_ap > 10)
									<button style="margin: 0 auto; display: inherit;" class="show_a_f_p btn btn-primary btn-small">MORE</button>
									@endif
								</ul>
								<div class="clearfix"></div>
							</div>
						</div>
						<br>

					</div>
				</div>
			</div>
		</div>

           <div class="col-xs-12 col-md-9">

           </div>

@endsection

