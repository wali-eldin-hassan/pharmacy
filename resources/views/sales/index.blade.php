@extends('layouts.app')
@section('title', '| Sales')
@section('content')
    <div class="col-md-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('sales.title')
            </div>
            <div class="panel-body">
                <div id="tablePanel">
                    <!-- Pdf generate dropdown -->
                    <div class="dropdown" id="pdfgenerate">
                        <button class="btn btn-sm btn-info  dropdown-toggle" data-toggle="dropdown">
                            @lang('products.inventory')
                            <span class="caret">
                    </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/sales/pdf/0')}}"> All </a></li>
                            <li><a href="{{url('/sales/pdf/1')}}"> Week </a></li>
                            <li><a href="{{url('/sales/pdf/2')}}"> Month </a></li>
                            <li><a href="{{url('/sales/pdf/3')}}"> 6 Month </a></li>
                            <li><a href="{{url('/sales/pdf/4')}}"> Year </a></li>
                        </ul>
                    </div> <!-- end div #pdfgenerate -->
                </div> <!-- end div #tablePanel -->
                <div class="col-md-4" id="searchDiv">
                    <div id="custom-search-input">
                        <div class="input-group ">
                            <input type="text" class="form-control input-md" id="SearchSales" name="search"
                                   placeholder="@lang('products.search')"/>
                            <span class="input-group-btn">
                         <button class="btn btn-info btn-md" type="button">
                         <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                     </span>
                        </div>
                    </div>
                </div>  <!-- end div #searchDiv -->
                <!-- Table -->
                <div class="col-md-12 col-sm-12">
                    <div class="table-responsive" id="divProductTable">
                        <table class="table table-responsive results">
                            <tr>
                                <th>
                                    @lang('sales.invoiceno')
                                </th>
                                <th>
                                    @lang('sales.products')
                                </th>
                                <th>
                                    @lang('sales.tprice')
                                </th>
                                <th>
                                    @lang('sales.saledate')
                                </th>
                                <th class="text-center" >
                                    @lang('sales.control')
                                </th>
                            </tr>
                            <tbody id="salesDivBoxAjax">
                            </tbody>
                            <tbody id="salesDivBox">
                            @foreach($sales as $sale)
                                <tr>
                                    <td>
                                        {{  $sale->invoice_no   }}
                                    </td>
                                    <td style="word-break: break-all;">
                                        {{  $sale->name }}
                                    </td>
                                    <td>
                                        <small style="float: left;">
                                            {{get_currencySymbols() }}
                                        </small>
                                        {{  floatval($sale->price) }}
                                    </td>
                                    <td>
                                        {{  date('d-M-Y-g:i', strtotime($sale->created_at)) }}
                                    </td>
                                    <td>
                                        <a href="{{route('sales.invoice', $sale->order_code)}}">
                                            <button class="btn btn-xs btn-white">
                                                <i aria-hidden="true" class="fa fa-print">
                                                </i>
                                                @lang('button.print')
                                            </button>
                                        </a>
                                        <a href="{{route('sales.show', $sale->order_code)}}">
                                            <button class="btn btn-xs btn-white">
                                                <i aria-hidden="true" class="fa fa-eye">
                                                </i>
                                                @lang('button.show')
                                            </button>
                                        </a>
                                        {{Form::open(['route' => ['sales.destroy', $sale->order_code], 'method' => 'DELETE' ,  'id' => 'deleteFormSale'])}}

                                        {{Form::button('
                                        <i aria-hidden="true" class="fa fa-trash-o">
                                        </i>
                                        '. trans('button.delete'), ['class'=>'btn btn-xs btn-danger deleteBtnSale', 'type'=>'submit', 'data-id' => $sale->order_code]) }}

                                        {{Form::close()}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-left">
                            {{$sales->links()}}
                        </div>
                    </div> <!-- end div #divProductTable -->
                </div> <!-- end col 12-->

                <!-- Print page -->

                @if(session()->has('success'))
                    @if(get_setting()->ph_print === '1' || get_setting()->ph_print === '2')
                        @include('invoice.1')
                    @elseif(get_setting()->ph_print === '3' || get_setting()->ph_print === '4')
                        @include('invoice.2')
                    @endif
                @endif

                <script>
                    /*
                     Products search
                     */

                    //Language
                    var _show = '@lang('products.show')';
                    var _edit = '@lang('products.edit')';
                    var _delete = '@lang('products.delete')';
                    $(function () {
                        $("#SearchSales").keyup(function () {
                            var _search = $(this).val();
                            if (_search === '') {
                                $('#salesDivBoxAjax').hide();
                                $('#salesDivBox').show();
                                return false;
                            }
                            $.ajax({
                                type: 'POST',
                                dataType: "json",
                                url: '/sales/search',
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'search': _search
                                },
                                success: function (data) {
                                    var $a;
                                    $.each(data, function (i, result) {
                                        if (jQuery.isEmptyObject(result.RoleOwners)) {
                                            $('#salesDivBox').hide();
                                            $('#salesDivBoxAjax').show();
                                            $a += '<tr>',
                                                $a += '<td >' + result.order_code + '</td >',
                                                $a += '<td >' + result.name + '</td >',
                                                $a += '<td ><small style="float: left;"> {{get_currencySymbols() }} </small>' + result.price + '</td >',
                                                $a += '<td >' + result.created_at + '</td >',
                                                $a += '<td >',
                                                $a += '<a href="/sales/' + result.order_code + '"><button class="btn btn-xs btn-white"><i class="fa fa-eye" aria-hidden="true"></i>' + _show + '</button></a>',
                                                $a += '<form method="POST" action="sales/' + result.order_code + '" accept-charset="UTF-8" style="display:inline-block;" id="deleteFormSale"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="' + $('input[name=_token]').val() + '">',
                                                $a += '<button class="btn btn-xs btn-danger deleteBtnSale" type="submit"><i class="fa fa-trash-o" aria-hidden="true"></i>' + _delete + '</button>',
                                                $a += '</form>',
                                                $a += '</td >'
                                        }
                                    });
                                    $('tbody#salesDivBoxAjax').html($a);
                                }
                            });
                        });


                    });
                </script>
            </div>
        </div>
    </div>
@endsection
