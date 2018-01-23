@extends('layouts.queen')

@section('content')
    <div class="row">

            <div class="col-md-6">
                <div class="jumbotron">

                    <table class="table hover">
                        <tr>
                            <th>
                                Followers
                            </th>

                            <th>
                                Settings
                            </th>
                        </tr>

                        @foreach($followers_res as $fwers_val)
                            <tr>

                                <td>
                                    <img class="folow_p_avatar" src="{{ Request::root() }}/assets/images/{{$fwers_val->avatar}}" alt="">
                                    {{$fwers_val->username}}
                                </td>

                                <td>
                                    @if (!Auth::user()->isFollowing($fwers_val))
                                        <a href="{{ route('users.follow', $fwers_val) }}" class="btn btn-danger btn-cons">Follow</a>
                                    @endif
                                </td>


                            </tr>


                        @endforeach

                    </table>


                </div>
            </div>




            <div class="col-md-6">


                <div class="jumbotron">

                    <table class="table hover">
                        <tr>
                            <th>
                                Following
                            </th>

                            <th>
                                Settings
                            </th>
                        </tr>

                        @foreach($following_res as $fwing_val)
                            <tr>

                                <td>
                                    <img class="folow_p_avatar" src="{{ Request::root() }}/assets/images/{{$fwing_val->avatar}}" alt="">
                                    {{$fwing_val->username}}
                                </td>

                                <td>
                                    <a href="{{ route('users.unfollow', $fwing_val) }}" class="btn btn-danger btn-cons">Unfollow</a>
                                </td>


                            </tr>


                        @endforeach

                    </table>


                </div>


            </div>



    </div>


@endsection

