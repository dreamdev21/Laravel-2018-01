@extends('admin.king')

@section('content')

    @if(\Session::has('error'))
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
            {{\Session::get('error')}}
        </div>
    @endif

    @if(\Session::has('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert"></button>
        {{\Session::get('success')}}
    </div>
    @endif

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Settings</h2>

                @if(!$studio->paypal_email)
                    <form action="/studio/settings/addemail" method="post">
                        {{csrf_field()}}
                        <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">PayPal E-mail</div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p>Enter your PayPal E-mail</p>
                            <input type="email" name="email" style="min-height: 40px; width: 50%;" required>
                            <input class="btn btn-danger btn-lg" type="submit" name="submit" value=" Accept ">
                        </div>
                    </div>
                    </form>

                @else

                    <form action="/studio/settings/editemail" method="post">
                        {{csrf_field()}}
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">PayPal E-mail</div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <p>Edit PayPal E-mail</p>
                                <input type="email" name="email" value="{{$studio->paypal_email}}" style="min-height: 40px; width: 50%;" required>
                                <input class="btn btn-danger btn-lg" type="submit" name="submit" value=" Edit ">
                            </div>
                        </div>
                    </form>

                @endif



                @if($calcres < 50)
                <b>$ {{$calcres}} </b><br>
                <i>Minimum withdrawal amount $50</i>
                @else
                    <b>$ {{$calcres}} </b><br>
                    <a href="/studio/payment_request" class="btn btn-danger btn-lg"> Payment Request </a>
                @endif

                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="panel-body row-fluid" style="width: 70%;margin: 0 auto;background-color: white;border-radius: 10px;">

        <table id="adminmoviestv" class="display" cellspacing="0" width="100%">
            <thead class="table-header">
            <th>Amount</th>
            <th>Status</th>
            <th>Sent date</th>
            </thead>
            <tbody>
            @foreach($payreqres as $payrr)
                <tr>

                    <td>
                        <b><i>${{$payrr->amount}}</i></b>
                    </td>
                    <td>

                        @if($payrr->status == 1)
                            <span class="label">PENDING</span>
                        @elseif($payrr->status == 2)
                            <span class="label label-important">ON HOLD</span>
                        @elseif($payrr->status == 3)
                            <span class="label label-info">PAID</span>
                        @endif

                    </td>
                    <td>
                        {{substr($payrr->created_at, 0, 16)}}
                    </td>

                </tr>
            @endforeach

            </tbody>
        </table>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
        {{csrf_field()}}
    </div>

@stop
