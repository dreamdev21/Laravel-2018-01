@extends('admin.king')

@section('content')

    <div class="row">
        <div class="panel panel-default">

            <h2 class="panel-heading">All Advertising</h2>
            <a href="{{ route('tvAd_create') }}" type="button" class="btn btn-danger">Create new advertisement</a>

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
