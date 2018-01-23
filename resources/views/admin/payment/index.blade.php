@extends('admin.king')

@section('content')

    <div class="alert alert-success sub_stud_status_mess">
        Save
    </div>

    <div class="row">
        <div class="panel panel-default">

            <h2 class="panel-heading">All Payment Requests</h2>

        </div>
    </div>


    <hr>

    <div class="panel-body row-fluid" style="width: 80%;margin: 0 auto;background-color: white;border-radius: 10px;">

        <table id="adminmoviestv" class="display" cellspacing="0" width="100%">
            <thead class="table-header">
            <th>Studio Name</th>
            <th>Amount</th>
            <th>Studio Pay-Pal E-mail</th>
            <th>Status</th>
            <th>Sent date</th>
            </thead>
            <tbody>
            @foreach($payreq as $payrr)
                <tr>

                    <td>
                        {{$payrr->studio->name}}
                    </td>

                    <td>
                        <b><i>${{$payrr->amount}}</i></b>
                    </td>

                    <td>
                        {{$payrr->studio->paypal_email}}
                    </td>

                    <td>

                        <div class="form-group">
                            <select class="form-control" onchange="subStatForStudio( '{{$payrr->id}}', this )">
                                <option value="1"
                                @if($payrr->status == 1)
                                    selected
                                @endif
                                >PENDING</option>
                                <option value="2"
                                @if($payrr->status == 2)
                                selected
                                @endif
                                >ON HOLD</option>
                                <option value="3"
                                @if($payrr->status == 3)
                                selected
                                @endif
                                >PAID</option>
                            </select>
                        </div>

                        {{--@if($payrr->status == 1)--}}
                            {{--<span class="label">PENDING</span>--}}
                        {{--@elseif($payrr->status == 2)--}}
                            {{--<span class="label label-warning">ON HOLD</span>--}}
                        {{--@elseif($payrr->status == 3)--}}
                            {{--<span class="label label-info">PAID</span>--}}
                        {{--@endif--}}

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

@endsection
