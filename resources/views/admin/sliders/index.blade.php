@extends('admin.king')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <h2>Movie Slides</h2>

        @if(Session::has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Great!</strong> {{Session::get('success')}}
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Oh snap!</strong> {{Session::get('error')}}
            </div>
        @endif

        <div class="col-md-9 m-t-50">
            <table class="table table-striped table-flip-scroll cf">
                <thead class="table-header">
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($slides as $slide)
                    <tr>

                        <td>
                            {{ $slide->id }}
                        </td>
                        <td>
                            {{ $slide->title }}
                        </td>

                        <td>
                            <p>

                                {!! Form::open(array('route' => array('sliders', $slide->id), 'method' => 'DELETE')) !!}
                                {!! Form::submit('DELETE', ['class' => 'btn btn-danger btn-block']) !!}
                                {!! Form::close() !!}

                            </p>
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="col-md-3 m-t-50 well">

            <form action="{{ route('sliders.store') }}" method="post" >


                <div class="form-group">
                    <label class="form-label" id="name" name="name">Name</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                </div>


                <div class="col-md-12 m-b-50">
                    <button type ="submit" class="btn btn-lg btn-primary"> ADD NEW SLIDE </button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}" />
                </div>

            </form>
        </div>
    </div>
@endsection