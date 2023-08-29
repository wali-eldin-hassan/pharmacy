@extends('layouts.app')
@section('title', '| Show')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('sales.titleShow')</div>
        <div class="panel-body">

            <div class="col-md-10" id="customerInfo">
                @foreach($custorders as $key => $cust)
                    @if($key === 0)
                        <div class="col-md-6" id="customer-address">
                            <strong>@lang('customers.address')</strong>
                            <p>{{$cust->address}}</p>
                            <strong>@lang('customers.phone')</strong>
                            <p>{{$cust->phone}}</p>
                            <strong>@lang('customers.customerno')</strong>
                            <p>{{$cust->customer_number}}</p>
                        </div>

                        <div class="col-md-6" id="customer-info">
                            <strong>@lang('customers.name')</strong>
                            <p>{{$cust->name}}</p>
                            <strong>@lang('customers.date')</strong>
                            <p>{{$cust->created_at}}</p>
                            <strong>@lang('customers.info')</strong>
                            <p>{!! $cust->info !!}</p>
                        </div>
                    @endif
                @endforeach
            </div>  <!-- end div #customerInfo !-->

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-hover results">
                        <tr>
                            <th>@lang('customers.name')</th>
                            <th>@lang('customers.discount')</th>
                            <th>@lang('customers.price')</th>
                            <th>@lang('customers.description')</th>

                        </tr>
                        <tbody>
                        @foreach($custorders as $cust)
                            <tr>
                                <td>{{  $cust->drugname   }}</td>
                                <td>{{  $cust->discount   }}%</td>
                                <td>
                                    <small style="float: left;"> {{get_currencySymbols() }} </small>{{  $cust->price   }}
                                </td>
                                <td>{{  $cust->druginfo   }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table> <!-- end div #results !-->
                </div>
            </div> <!-- end col 8-->

            <div class="col-md-4">
                <table class="table table-hover results">
                    <tr>
                        <th>@lang('customers.customerno')</th>
                        <th class="text-center">@lang('customers.date')</th>
                    </tr>
                    <tbody>
                    @foreach($lastsale as $ls)
                        <tr>
                            <td>{{  $ls->cust_no   }}</td>
                            <td>{{  $ls->created_at   }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>   <!-- end table #results -->
            </div>   <!-- end col 4 -->
            <div class="col-md-12">
                {{Form::open(['route' => 'customers.store'])}}
                <input type="hidden" value="{{ \Request::segment(2) }}" name="customerno">
                <button class="btn btn-info">@lang('sell.sell')</button>
                {{Form::close()}}
            </div>
        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel -->

    <!-- Print paper -->

    @if(session()->has('success'))

        @if(get_setting()->ph_print === '1' || get_setting()->ph_print === '2')
            @include('invoice.invoice_customer.1')
        @elseif(get_setting()->ph_print === '3' || get_setting()->ph_print === '4')
            @include('invoice.invoice_customer.2')
        @endif

    @endif

@endsection
