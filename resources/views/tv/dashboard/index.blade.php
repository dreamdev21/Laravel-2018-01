@extends('admin.king')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-md-4" style="height: 400px">
                <h3>Watching statistics</h3>
                <canvas id="myChart" width="400px" height="400px" style="width: 400px; height: 400px;"></canvas>
            </div>
            <div class="col-md-2">
                <h3>Now watching - <span id="watchers">0</span></h3>
            </div>
        </div>
    </div>
@stop



@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
    <script>
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };
        var channel_id = "{{$channel}}";
        $(document).ready(function () {
            $.ajax({
                type: 'get',
                url: 'get_statistics',
                success: function(res){
                    var data = [];
                    var countries = [];
                    for(var i = 0; i < res.length; i++){
                        data.push(res[i][1]);
                        countries.push(res[i][0]);
                    }
                    generateChart(data, countries);
                }
            });
            getWatchers();
            onlineWatchers();
        });

        function generateChart(data, countries){
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: data,
                        backgroundColor: generateColors(),
                        label: 'Dataset 1'
                    }],
                    labels: countries
                },
                options: {
                    responsive: true
                }
            });
            $('#myChart').css({'width':'400px','height':'400px'});
        }

        function generateColors(){
            var colors = [];
            for(var j = 0; j < 100; j++){
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++ ) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                colors.push(color);
            }
            return colors;
        }

        function onlineWatchers() {
            setInterval(function () {
                getWatchers();
            }, 5000);
        }

        function getWatchers() {
            $.get(baseurl +':3000/watchers', {}, function(data){
                if(channel_id in data['watchers']){
                    var count = data['watchers'][channel_id].length;
                    $('#watchers').html('');
                    $('#watchers').html(count);
                }
            });
        }
    </script>
@stop