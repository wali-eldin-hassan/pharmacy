@extends('layouts.app')
@section('title', '| Show')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('sales.titleShow')</div>

        <div class="panel-body">
            <table class="table table-hover results">
                <tr>
                    <th>@lang('sales.invoiceno')</th>
                    <th>@lang('sales.products')</th>
                    <th>@lang('sales.price')</th>
                    <th>@lang('products.quantity')</th>
                    <th>@lang('sales.discount')</th>
                    <th>@lang('sales.description')</th>
                    <th>@lang('sales.saledate')</th>
                </tr>
                <tbody></tbody>
                <tbody>
                @foreach($sale as $sales)
                    <tr>
                        <td>{{ $sales->order_code }}</td>
                        <td>{{ $sales->name }}</td>
                        <td>
                            <small style="float: left;"> {{get_currencySymbols() }} </small>{{ $sales->price }} </td>
                        <td>{{$sales->quantity}}</td>
                        <td>{{ $sales->p_discount }}%</td>
                        <td>{{ $sales->info }}</td>
                        <td>{{ date('F j , Y, g:i h', strtotime($sales->created_at )) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>   <!-- end table .results -->
            <p><strong>@lang('sales.tprice')</strong>
                <?php
                $a = 0;
                foreach ($sale as $sales) {
                    $a += ($sales->price * $sales->quantity) - ($sales->price * ($sales->p_discount / 100));
                }
                echo $a . get_currencySymbols();
                ?>
            </p>
        </div>  <!-- end div .panel-body -->
    </div>  <!-- end div .panel -->

@endsection
