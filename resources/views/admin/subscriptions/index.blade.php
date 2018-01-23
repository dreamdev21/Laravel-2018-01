@extends('admin.king')

@section('content')
    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-3.2.0.min.js" type="text/javascript"></script>

    <h3>Subscription plans</h3>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$basic['id']}}</td>
                    <td>{{$basic['name']}}</td>
                    <td>{{$basic['amount']}} $</td>
                    <td><button class="btn btn-primary btn-small sub-edit" id="{{$basic['id']}}" data-toggle="modal" data-target="#subscriptionModal">Edit</button></td>
                </tr>
                <tr>
                    <td>{{$pro['id']}}</td>
                    <td>{{$pro['name']}}</td>
                    <td>{{$pro['amount']}} $</td>
                    <td><button class="btn btn-primary btn-small sub-edit" id="{{$pro['id']}}" data-toggle="modal" data-target="#subscriptionModal">Edit</button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Subscription Modal -->
    <div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="subscription-body">

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script type="text/javascript">

        $('.sub-edit').on('click', function (e) {
                $.ajax({
                    type: 'get',
                    url: 'subscription/'+e.target.id,
                    success: function(res){
                        $('#subscription-body').html('');
                        $('#subscription-body').html(res);
                    }
                })
        });
    </script>
@endsection