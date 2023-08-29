@extends('layouts.app')
@section('title', '| Dashboard')
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('dashboard.dashboard')</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div id="allSales">
                            <div id="pContent">
                                <h3>
                                    @if(!empty($totalproduct))
                                        {{$totalproduct[0]->totalproduct}}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <hr>
                                <p>
                                    {{product($dayProduct['yasterday'],$dayProduct['today'])}}
                                    @lang('dashboard.instock') </p>
                            </div> <!-- end div #pContent -->
                            <i class=" fa fa-archive fa-5x"></i>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3  col-xs-12">
                        <div id="totalSale">
                            <div id="pContent">
                                <h3>
                                    @if(!empty($totalsale))
                                        {{floatval($totalsale[0]->totalsale)}} $
                                    @else
                                        0$
                                    @endif
                                </h3>
                                <hr>
                                <p>
                                    {{check($daySales['yasterday'],$daySales['today'])}}
                                    @lang('dashboard.totalsales') </p>
                            </div>  <!-- end div #pContent -->
                            <i class="fa fa-cart-plus fa-5x"></i>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div id="totalPurchases">
                            <div id="pContent">
                                <h3>
                                    @if(!empty($totalpurchases))
                                        {{$totalpurchases[0]->totalpurchases}} $
                                    @else
                                        0$
                                    @endif
                                </h3>
                                <hr>
                                <p>
                                    {{check($dayPurchases['yasterday'],$dayPurchases['today'])}}
                                    @lang('dashboard.totalpurchases') </p>
                            </div>    <!-- end div #pContent -->
                            <i class="fa fa-truck fa-5x"></i>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div id="totalCustomers">
                            <div id="pContent">
                                <h3>
                                    @if(!empty($totalcustomers))
                                        {{$totalcustomers[0]->customers}}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <hr>
                                <p>
                                    {{product($dayCustomers['yasterday'],$dayCustomers['today'])}}
                                    @lang('customers.title') </p>
                            </div>   <!-- end div #pContent -->
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                    </div>
                </div>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div> <!-- end col 12 -->
    <div class="col-md-8 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('dashboard.analysis')</div>
            <div class="panel-body">
                <div class="col-md-12  col-sm-12 col-xs-12 pull-right">
                    <canvas id="salesMoney" width="200"></canvas>
                </div>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div> <!-- end col 8 -->
    <div class="col-md-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('dashboard.analysisTop')</div>
            <div class="panel-body">
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <canvas id="topSalesProducts" width="200"></canvas>
                </div>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div> <!-- end col 4 -->
    <!--Latest customers -->
    <div class="col-md-8 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('dashboard.lastcustomer') </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <tr>
                            <th>#</th>
                            <th>@lang('customers.name')</th>
                            <th>@lang('customers.address')</th>
                            <th>@lang('customers.phone')</th>
                            <th>@lang('customers.info')</th>
                            <th>@lang('customers.date')</th>
                        </tr>
                        <tbody id="cuctomersDivBox">
                        @if(!empty($customers))
                            @foreach($customers as $cust)
                                <tr>
                                    <td>{{  $cust->id      }}</td>
                                    <td>{{  $cust->name   }}</td>
                                    <td>{{  $cust->address     }}</td>
                                    <td>{{  $cust->phone  }}</td>
                                    <td>{{  date('F j, Y', strtotime($cust->created_at))  }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>   <!-- end tbody #cuctomersDivBox -->
                    </table>  <!-- end div table -->
                </div>
            </div> <!-- end div .panel-body -->
        </div> <!-- end div .panel -->
    </div> <!-- end col 8 -->
    @if(!empty($customers))
        <div class="col-md-4 col-xs-12">
            @foreach($note as $no)
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body {{$no->color}}" id="noteContent">
                            <div class="form-group label-floating" style="margin: 0;">
                                <p class="noteName">{{$no->name}}</p>
                                <small class="noteDate">{{$no->created_at}}</small>
                            </div>
                            <div class="form-group label-floating" style="margin-top: 0;">
                                <textarea class="form-control" id="noteText" cols="20" id="" maxlength="200"
                                          name="noteText" rows="5" disabled>{{$no->content}} </textarea>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col 12 -->
            @endforeach
            @endif
        </div> <!-- end col 4 -->
        </div> <!-- end div .panel-body -->
        <script src="{{ asset('js/plugins/Chart.min.js') }}"></script>
        <script>

            /*
             Sales Chart
             */
            var ctx = $("#topSalesProducts");
            var salesChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [@if(!empty($salequantity)) @foreach($salequantity as $a) {!! '"'.$a->money.'",' !!}@endforeach @endif],
                    datasets: [{
                        backgroundColor: ['#f44336', '#e91e63', '#03a9f4', '#004d40', '#ffc400', '#ff5722', '#263238', '#4caf50', '#6200ea', '#880e4f'],
                        hoverBackgroundColor: "rgba(75,192,192,0.4)",
                        data: [@if(!empty($salequantity)) @foreach($salequantity as $a){{$a->total.','}}@endforeach @endif]
                    }
                    ]
                }
            });

            /*
             Sales money within a year
             */

            var ctx = $("#salesMoney");
            var salesMoney = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [@if(!empty($apurchases)) @foreach($apurchases as $a) {!! '"'.$a->month.'",' !!}@endforeach @endif],
                    datasets: [
                        {
                            label: "@lang('dashboard.amountmoney')",
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
                            data: [@if(!empty($salemoney)) @foreach($salemoney as $a){{$a->money.','}}@endforeach @endif],
                            spanGaps: false,
                        }, {
                            label: "@lang('dashboard.amountpurchases')",
                            pointHoverBackgroundColor: "rgba(244, 67, 53,1)",
                            pointHoverBorderColor: "rgba(244, 67, 53,1)",
                            pointBorderColor: "rgba(14, 0, 0,1)",
                            pointBackgroundColor: "#fff",
                            backgroundColor: "rgba(244, 67, 53, 0.67)",
                            borderColor: "rgba(244, 67, 53,1)",
                            data: [@if(!empty($apurchases)) @foreach($apurchases as $a){{$a->money.','}}@endforeach @endif],
                        }
                    ]
                }
            });
        </script>
@endsection

