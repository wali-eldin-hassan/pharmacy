@extends('layouts.app')
@section('title', '| Anaylsis sales')
@section('content')
    <div class="col-md-4">
        <div id="anaylsisSales">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
            <div id="text">
                <h2>@lang('analysis.today')</h2>
                <h3>
                    {{check($day['yasterday'],$day['today'])}}
                </h3>
            </div>
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
                <canvas id="month" width="200"></canvas>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="barDay" width="200"></canvas>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="barWeek" width="200"></canvas>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div>


    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="barMonth" width="200"></canvas>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div>


    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="barYear" width="200"></canvas>
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
                    label: [@if(!empty($week)) @foreach($week as $a) {!! '"'.$a->day.'",' !!}@endforeach @endif],
                    data: [@if(!empty($week)) @foreach($week as $a) {!! '"'.$a->price.'",' !!}@endforeach @endif],
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
        var ctx = $("#month");
        var salesMoney = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@if(!empty($month)) @foreach($month as $a) {!! '"'.$a->month.'",' !!}@endforeach @endif],
                datasets: [
                    {
                        label: "@lang('analysis.yearly')",
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
                        data: [@if(!empty($month)) @foreach($month as $a){{$a->price.','}}@endforeach @endif],
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

        // top selling products Day

        var ctx = $("#barDay");
        var salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [@if(!empty($topDrugsDay)) @foreach($topDrugsDay as $a) {!! '"'.$a->price.'",' !!}@endforeach @endif],
                datasets: [{
                    backgroundColor: ['#f44336', '#e91e63', '#03a9f4', '#004d40', '#ffc400', '#ff5722', '#263238', '#4caf50', '#6200ea', '#880e4f'],
                    hoverBackgroundColor: "rgba(75,192,192,0.4)",
                    data: [@if(!empty($topDrugsDay)) @foreach($topDrugsDay as $a){{$a->total.','}}@endforeach @endif]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: "@lang('analysis.topd')"
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });


        // top selling products Day
        var ctx = $("#barWeek");
        var salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [@if(!empty($topDrugsWeek)) @foreach($topDrugsWeek as $a) {!! '"'.$a->price.'",' !!}@endforeach @endif],
                datasets: [{
                    backgroundColor: ['#f44336', '#e91e63', '#03a9f4', '#004d40', '#ffc400', '#ff5722', '#263238', '#4caf50', '#6200ea', '#880e4f'],
                    hoverBackgroundColor: "rgba(75,192,192,0.4)",
                    data: [@if(!empty($topDrugsWeek)) @foreach($topDrugsWeek as $a){{$a->total.','}}@endforeach @endif]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: "@lang('analysis.topw')"
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // top selling products Day
        var ctx = $("#barMonth");
        var salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [@if(!empty($topDrugsMonth)) @foreach($topDrugsMonth as $a) {!! '"'.$a->price.'",' !!}@endforeach @endif],
                datasets: [{
                    backgroundColor: ['#f44336', '#e91e63', '#03a9f4', '#004d40', '#ffc400', '#ff5722', '#263238', '#4caf50', '#6200ea', '#880e4f'],
                    hoverBackgroundColor: "rgba(75,192,192,0.4)",
                    data: [@if(!empty($topDrugsMonth)) @foreach($topDrugsMonth as $a){{$a->total.','}}@endforeach @endif]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: "@lang('analysis.topm')"
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // top selling products Day
        var ctx = $("#barYear");
        var salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [@if(!empty($topDrugsYear)) @foreach($topDrugsYear as $a) {!! '"'.$a->price.'",' !!}@endforeach @endif],
                datasets: [{
                    backgroundColor: ['#f44336', '#e91e63', '#03a9f4', '#004d40', '#ffc400', '#ff5722', '#263238', '#4caf50', '#6200ea', '#880e4f'],
                    hoverBackgroundColor: "rgba(75,192,192,0.4)",
                    data: [@if(!empty($topDrugsYear)) @foreach($topDrugsYear as $a){{$a->total.','}}@endforeach @endif]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: "@lang('analysis.topy')"
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    </script>
@endsection
