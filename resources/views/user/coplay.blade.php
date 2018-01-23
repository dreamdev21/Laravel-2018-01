@extends('layouts.queen')

@section('content')
    {{--{{dd($followers_res, $following_res)}}--}}

    <div class="row">

        <div class="col-md-6">
            <div class="jumbotron">

                <table class="table hover">
                    <tr>
                        <th>
                            Invitation from
                        </th>

                        <th>
                            Movie
                        </th>
                    </tr>
                    @if(isset($colay_inv['users']))
                    @for($i = 0; $i < count($colay_inv['users']); $i++)
                        <tr>
                            <td>
                                <a href="/users/{{$colay_inv['users'][$i]->username}}">
                                    <img class="folow_p_avatar" src="{{ Request::root() }}/assets/images/{{$colay_inv['users'][$i]->avatar}}" alt="">
                                    {{$colay_inv['users'][$i]->username}}
                                </a>
                                <hr>
                            </td>
                            <td>
                                <a href="/movies/{{$colay_inv['movies'][$i]->slug}}">
                                    <img class="folow_p_avatar" src="{{ asset('assets/images/' . $colay_inv['movies'][$i]->poster ) }}" alt="">
                                    {{$colay_inv['movies'][$i]->title}}
                                </a>
                                <hr>
                            </td>
                        </tr>

                    @endfor
                    @endif
                </table>


            </div>
        </div>

    </div>

@endsection

