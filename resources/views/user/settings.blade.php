@extends('layouts.queen')


@section('content')


               @if(Session::has('success'))
               <div class="alert alert-success">
                   <strong>Success!</strong> {{ Session::get('success') }}
               </div>
               @endif
               @if(Session::has('failed'))
               <div class="alert alert-success">
                   <strong>Success!</strong> {{ Session::get('failed') }}
               </div>
               @endif
            <div class="page-title" style="margin-top: 70px">
            <h3>Account Setting</h3>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="grid-body">

                    <div class="col-lg-6">

                      <h4>Change your password</h4>

                        <form method="POST" action="{{ URL::to('/users/settings/password-change') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                              <div class="form-group">
                                    <label class="form-label">Old password</label>
                                    <div class="controls">
                                      <input type="text" class="form-control" name="oldPassword" autocomplete="off" required>
                                    </div>
                              </div>
                              <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <div class="controls">
                                      <input type="password" class="form-control" name="newPassword" autocomplete="off" required>
                                    </div>
                              </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <div class="controls">
                                    <input type="password" class="form-control" name="password_confirmation" autocomplete="off" required>
                                </div>
                            </div>
                             <div class="button-set">
                                <button class="btn btn-danger btn-cons" type="submit">Change my password</button>
                                 <input type="hidden" name="_token" value="{{ Session::token() }}" />
                              </div>

                        </form>
                        <br>


                        <h4 id="chatHistoryLable"> Chat History </h4>
                        <form method="POST" id="chatHistory" action="{{route('userSettingChatHistory') }}">
                            <div class="form-group">
                                <div class="button-set">
                                    <button class="btn btn-danger btn-cons" type="submit"><?=Auth::user()->chat_history == 0? "Turn On Chat History" : "Turn Off Chat History" ;?> </button>
                                    <input type="hidden" name="_token" value="{{ Session::token() }}" />
                                </div>
                            </div>

                        </form>

                    </div>
                    
                    <div class="col-lg-5">
                        <h4>Account Plan:</h4>
                        @if(Auth::user()->card_last_four && Auth::user()->braintree_token && Auth::user()->braintree_id)
                            <form method="POST" id="disableSavedPayment" action="{{route('disableSavedPayment') }}">
                                {{ csrf_field() }}
                                <div class="button-set">
                                    <button class="btn btn-danger btn-cons "  type="submit">Disable Saved Payment </button>

                                </div>
                            </form>
                        @else
                            <div class="button-set">
                                <button class="btn btn-danger btn-cons disabled"  type="button">You do not have Saved Payment </button>
                            </div>
                        @endif
                        <br>
                        <hr>

                        <h4>Profile picture</h4>
                        <form method="POST" action="{{ URL::to('/users/'. Auth::user()->username . '/settings/avatar') }}" accept-charset="UTF-8" class="p-t-15 ng-pristine ng-valid" id="profileUpload" novalidate="novalidate" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="alert alert-danger" role="alert" id="alertProfile" style="display: none;">
                                <button class="close" data-dismiss="alert"></button>
                                <p><strong>Error</strong></p>
                                <p id="errorProfile">hola</p>
                            </div>

                            <div class="paddidata-ng-5 b-rad-lg">
                                <div class="row">
                                    <div class="col-sm-12 p-t-10 p-l-10 p-r-10">
                                        <div class="form-group form-group-default required">
                                            <input class="required" accept="image/*" required="true" name="avatar" type="file" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-danger btn-cons m-t-10 m-b-50" id="changeProfileButton" type="submit">Change profile</button>
                            </div>
                        </form>
                        <hr>
                     <h4>Cancel Membership</h4>
                        <p>You can cancel your account anytime. No commitments, no contract.</p>
                        <div class="button-set">

                        <button class="btn btn-danger btn-cons" type="button" data-toggle="modal" data-target="#cancelModal">Cancel Membership</button>
                       
                      </div>
                    </div>

                </div>
           
            </div>
          </div>

@endsection


@section('modal')
    <div class="modal fade stick-up" id="cancelModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-white">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="bluetext">Are you sure you want to cancel your account?</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 m-t-10 sm-m-t-10">

                                <div class="alert alert-danger" role="alert">
                                    <h3><strong>Important! </strong></h3>
                                    <p> Cancelling your account will disable your profile and access to having a memorable time with your friends.</p>
                                </div>

                            <button class="btn btn-danger btn-cons m-b-10" style="float: left;" data-dismiss="modal">Stay on Entertale</button>

                            <form id="checkout" method="post" action="{{route('cancel')}}" style="float: left;">
                                {!! csrf_field() !!}
                                <input class="btn btn-success btn-cons " type="submit" value="Cancel your account" >
                                <button class="btn btn-success btn-cons" id="cancelSubscription" style="display: none;">Cancel your account</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection



