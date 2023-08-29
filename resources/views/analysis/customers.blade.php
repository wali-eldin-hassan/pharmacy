@extends('layouts.app')
@section('title', '| Analysis customers')
@section('content')

    <div class="col-md-4">
        <div id="anaylsisCustomers">
            <p>@lang('analysis.lastc')</p>
            <ol>
                @foreach($lastCustomers as $last)
                    <li><a href="{{url('/customers').'/'.$last->number }}">{{$last->name}}</a></li>
                @endforeach
            </ol>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="day" width="200"></canvas>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="yearly" width="200"></canvas>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div>
    <script src="{{ asset('js/plugins/Chart.min.js') }}"></script>
    <script>
        //Week
        var ctx = $("#day");
        var DayChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [@if(!empty($week)) @foreach($week as $a) {!! '"'.$a->day.'",' !!}@endforeach @endif],
                datasets: [{
                    label: '@lang('analysis.most')',
                    data: [@if(!empty($week)) @foreach($week as $a) {!! '"'.$a->number.'",' !!}@endforeach @endif],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }],
            },
            options: {
                scales: {

                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: "@lang('analysis.weekly')"
                        }
                    }]
                }
            }
        });

        // Month
        var ctx = $("#yearly");
        var salesMoney = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@if(!empty($year)) @foreach($year as $a) {!! '"'.$a->month.'",' !!}@endforeach @endif],
                datasets: [
                    {
                        label: '@lang('analysis.yearly')',
                        fill: true,
                        lineTension: 0.1,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [@if(!empty($year)) @foreach($year as $a){{$a->number.','}}@endforeach @endif],
                        spanGaps: false,
                    }
                ]
            },

            options: {
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: "@lang('analysis.yearly')"
                        }
                    }]
                }
            }
        });

    </script>
@endsection
