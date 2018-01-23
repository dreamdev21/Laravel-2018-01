@extends('admin.king')



@section('content')
    <?php use App\Http\Controllers\AdminVideosController; ?>

	<div class="alert alert-success ads_save">
		<strong>Success!</strong>
	</div>

	@if (session('message'))
		<div class="alert alert-success">
			{{ session('message') }}
		</div>
	@endif

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-video"></i> Videos</h3><a href="@if(Auth::user()->role == 4){{ URL::to('tv/create') }}@else{{ URL::to('admin/videos/create') }}@endif" class="btn btn-danger"><i class="fa fa-plus-circle"></i> @if(Auth::user()->role == 4)Add new video @else Add new video to channels @endif</a>
			</div>
			<div class="col-md-4">

			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="panel-body">

		<table id="vidstaion" class="table table-striped table-flip-scroll cf">
			<thead class="table-header">
			<th>Status</th>
			<th>Title</th>
			<th>Url</th>
			<th>Duration</th>
			<th>Advertising</th>
			<th>Time</th>
			<th>Delete/Edit</th>
			</thead>
			<tbody>
			@foreach ($vide as $video)

				<tr>
					<td style="width:10%">
							{!!AdminVideosController::check_time_status($video->start_time , $video->end_time)  !!}

					</td>

					<td style="width:10%">
						{{ $video->title }}
					</td>
					<td>
						<p>
							{{ $video->url }}
						</p>
					</td>
					<td>
						<p>
							<b>{{ $video->dureation }}</b>
						</p>
					</td>

					<td>
						<div class="form-group">
							<select class="full-width select_video_ads"  name="adv_id" id="{{ $video->id }}">
								<option value="0">None</option>
								@foreach($ads as $ad)
									@if($ad->preroll_type == 'preroll')
									<option value="{{$ad->id}}" @if($ad->id == $video->ads_id) selected @endif>{{$ad->preroll_name}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</td>

					<td>
						<p>
							{{ $video->start_time }} <b> / </b> {{ $video->end_time }}
						</p>
					</td>
					<td>
						<p>
							<a href="@if(Auth::user()->role == 4){{ route('tvedit', $video->id) }}@else{{ route('videos.edit', $video->id) }}@endif" class="btn btn-xs btn-danger"> Edit</a>
						</p>
						<div class="album-options">
							@if(Auth::user()->role == 1)
								{!! Form::open(array('route' => array('videos.destroy', $video->id), 'method' => 'DELETE')) !!}
								{!! Form::submit('DELETE', ['class' => 'btn btn-success btn-block']) !!}
								{!! Form::close() !!}
							@else
								{!! Form::open(array('route' => array('tvdestroy', $video->id), 'method' => 'DELETE')) !!}
								{!! Form::submit('DELETE', ['class' => 'btn btn-success btn-block']) !!}
								{!! Form::close() !!}
							@endif

						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
		{{csrf_field()}}
	</div>
	@if(Auth::user()->role == 4)
		<script>
            var tv_select_video_ads = true;
		</script>
	@endif
@stop

@section('javascript')
	<script>

        $(document).ready(function(){
            var delete_link = '';

            $('.delete').click(function(e){
                e.preventDefault();
                delete_link = $(this).attr('href');
                swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
                return false;
            });
        });
	</script>
@stop
