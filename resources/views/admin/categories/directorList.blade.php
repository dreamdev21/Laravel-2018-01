@extends('admin.king')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <h2>Director List</h2>
        <div class="col-md-9 m-t-50">
            <table id="adminmoviestv" class="table table-striped table-flip-scroll cf">
                <thead class="table-header">
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($directors as $director)
                    <tr>

                        <td>
                            {{ $director->id }}
                        </td>
                        <td>
                            {{ $director->name }}
                        </td>

                        <td>
                            <p>

                                {!! Form::open(array('route' => array('directors.destroy', $director->id), 'method' => 'DELETE')) !!}
                                {!! Form::submit('DELETE', ['class' => 'btn btn-danger btn-block']) !!}
                                {!! Form::close() !!}

                            </p>
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
        <div class="col-md-3 m-t-50 well">

            <form action="{{ route('directors.store') }}" method="post" >
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="form-label" id="name" name="name">Name</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                </div>


                <div class="col-md-12 m-b-50">
                    <button type ="submit" class="btn btn-lg btn-primary btn-block btn-cons"><i class="fa fa-address-card-o" aria-hidden="true"></i> ADD NEW DIRECTOR </button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}" />
                </div>

            </form>
        </div>
    </div>
@endsection