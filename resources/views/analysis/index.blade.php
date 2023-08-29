@extends('layouts.app')
@section('title', '| Analysis')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('category.title')</div>
        <div class="panel-body">
            <div class="col-md-12" id="analysis">
                <div class="col-md-4">
                    <a href="{{url('/analysis/sales')}}">
                        <div id="sales">
                            <i class="fa fa-cart-plus fa-5x"></i>
                            <h3>@lang('analysis.sales')</h3>
                        </div>
                    </a>
                </div>   <!-- end div #sales -->

                <div class="col-md-4">
                    <a href="{{url('/analysis/purchases')}}">
                        <div id="purchases">
                            <i class="fa fa-truck fa-5x"></i>
                            <h3>@lang('analysis.purchases')</h3>
                        </div>  <!-- end div #purchase -->
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{url('/analysis/customers')}}">
                        <div id="customers">
                            <i class="fa fa-users fa-5x"></i>
                            <h3>@lang('analysis.cusotmers')</h3>
                        </div>  <!-- end div #customer -->
                    </a>
                </div>
            </div> <!-- end div #analysis -->
        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel -->
@endsection
