@extends('layouts.app')
@section('title', '| Sales')
@section('content')
    <head>
        @if(get_setting()->ph_print === '3')
            <link href="{{asset('css/invoice/trnto.css')}}" rel="stylesheet"></link> <!-- css b&w style -->
        @elseif(get_setting()->ph_print === '4')
            <link href="{{asset('css/invoice/trnto_colors.css')}}" rel="stylesheet"></link> <!-- css color style -->
        @endif
    </head>
    <div id="print">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h2>{{get_setting()->ph_name}}</h2>
                    <address>
                        @lang('print.fax'): {{get_setting()->ph_fax}}<br>
                        @lang('print.email'): {{get_setting()->ph_email}}<br>
                        @lang('print.telephone'): {{get_setting()->ph_telephone}}<br>
                        @lang('print.address'): {{get_setting()->ph_address}}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    @foreach($print as $key => $value)
                        <address>
                            @if($key === 0)`
                            <strong>@lang('print.invoiceno'):</strong><br>
                            {{$value->invoice_no}}<br><br>
                            <strong>@lang('print.invoicedate'):</strong><br>
                            {{$value->created_at}}<br><br>
                        </address>
                        @endif
                    @endforeach
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <td><strong>@lang('print.dname')</strong></td>
                                        <td class="text-center"><strong>@lang('print.price')</strong></td>
                                        <td class="text-center"><strong> @lang('print.quantity')</strong></td>
                                        <td class="text-right"><strong> @lang('print.discount')</strong></td>
                                        <td class="text-right"><strong> @lang('print.description')</strong></td>
                                        <td class="text-right"><strong> @lang('print.barcode')</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($print as $pr)
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                        <tr>
                                            <td>{{$pr->name}}</td>
                                            <td class="text-center"> {{$pr->price.get_currencySymbols()}}</td>
                                            <td class="text-center"> {{$pr->quantity}}</td>
                                            <td class="text-right">  {{$pr->p_discount}}%</td>
                                            <td class="text-right">
                                                @if(!empty($pr->info))
                                                    {{$pr->info}}
                                                @else
                                                    #
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if(!empty($pr->p_barcodeg))
                                                    {{$pr->p_barcodeg}}
                                                @else
                                                    #
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-6">
                                <strong>@lang('print.tprice')</strong>
                                <?php
                                $a = 0;
                                foreach ($print as $pre) {
                                    // (20*5) - (20*(20/100)) Discount all price
                                    $a += ($pre->price * $pre->quantity) - ($pre->price * ($pre->p_discount / 100));
                                }
                                echo $a . get_currencySymbols();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // open print if success
        $(function () {
            if ($('#print').length) {
                $('#print').printThis();
                setTimeout(function () {
                    $('#print').remove();
                    window.location = '/sales';
                }, 900);
            }
        });
    </script>

@endsection