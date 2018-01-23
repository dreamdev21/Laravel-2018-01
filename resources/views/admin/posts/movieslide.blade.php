@extends('admin.king')

@section('content')

    <a href="/admin/posts" type="button" class="btn btn-danger">< BACK</a>

    <div class="row">
        <div class="panel panel-default">
            <h2 class="panel-heading">Movie Slider</h2>

            <div class="panel-body">

                <div class="panel-body">

                <table id="adminmoviestv" cellspacing="0" width="100%" class="table display table-striped table-flip-scroll cf">
                    <thead class="table-header">
                        <th>#</th>
                        <th>image</th>
                        <th>Title</th>
                        <th>Slider</th>
                    </thead>
                    <tbody>
                    @foreach ($movies as $movie)
                        <tr>
                            <td>
                                {{ $movie->id }}
                            </td>

                            <td>
                                <p>
                                    <img src="{{ asset('assets/images/' . $movie->poster) }}" width="100px" hieght="100px" class="img-responsive" alt=""/>
                                </p>
                            </td>

                            <td style="width:20%">
                                {{ $movie->title }}
                            </td>

                            <td>
                                <div class="radio radio-success">
                                    <input class="subm_movei_slide_img" data-movid="{{$movie->id}}" id="yes_{{$movie->id}}" type="radio" name="optionyes_{{$movie->id}}" value="1"
                                           @if($movie->slide_public == 1)
                                           checked
                                            @endif
                                    >
                                    <label for="yes_{{$movie->id}}">Agree</label>

                                    <input class="subm_movei_slide_img" data-movid="{{$movie->id}}" id="no_{{$movie->id}}" type="radio" name="optionyes_{{$movie->id}}" value="0"
                                           @if($movie->slide_public == 0)
                                           checked
                                            @endif
                                    >
                                    <label for="no_{{$movie->id}}">Disagree</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                    <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">


            </div>
        </div>
    </div>

@endsection
