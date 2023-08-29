<head>
    @if(get_setting()->ph_print === '1')
        <link href="{{asset('css/invoice/b&w.css')}}" rel="stylesheet"></link> <!-- css b&w style -->
    @elseif(get_setting()->ph_print === '2')
        <link href="{{asset('css/invoice/colors.css')}}" rel="stylesheet"></link> <!-- style -->
    @endif
</head>
<div id="print">
    <div class="head">
        <div id="logo">
            <h1>
                {{get_setting()->ph_name}}
            </h1>
            <p>
                {{get_setting()->ph_address}}
            </p>
        </div>
        <div id="address">
            <p>
                <strong>
                    @lang('print.telephone')
                </strong>
                {{get_setting()->ph_telephone}}
            </p>
            <p>
                <strong>
                    @lang('print.email')
                </strong>
                {{get_setting()->ph_email}}
            </p>
            <p>
                <strong>
                    @lang('print.fax')
                </strong>
                {{get_setting()->ph_fax}}
            </p>
        </div>
        <div id="invoice">
            @foreach($print as $key => $value)
                @if($key === 0)`
                <p>
                    <strong>
                        @lang('print.invoiceno')
                    </strong>
                    {{$value->invoice_no}}
                </p>
                <p>
                    <strong>
                        @lang('print.invoicedate')
                    </strong>
                    {{$value->created_at}}
                </p>
                @endif
            @endforeach
        </div>
    </div>
    <table>
        <tr id="tablePanel2">
            <th>
                @lang('print.dname')
            </th>
            <th>
                @lang('print.quantity')
            </th>
            <th>
                @lang('print.price')
            </th>
            <th>
                @lang('print.discount')
            </th>
            <th id="tdInfo">
                @lang('print.description')
            </th>
            <th>
                @lang('print.barcode')
            </th>
        </tr>
        @foreach($print as $pr)
            <tr id="tablePanel">
                <td>
                    {{$pr->name}}
                </td>
                <td>
                    {{$pr->quantity}}
                </td>
                <td>
                    {{$pr->price.get_currencySymbols()}}
                </td>
                <td>
                    {{$pr->p_discount}}%
                </td>
                <td>
                    @if(!empty($pr->info))
                        {{$pr->info}}
                    @else
                        #
                    @endif
                </td>
                <td>
                    {{$pr->p_barcodeg}}
                </td>
            </tr>
        @endforeach
    </table>
    <hr>
    <div class="totalAmount">
        <p>
            <strong>
                @lang('print.tprice')
            </strong>
            <?php
            $a = 0;
            foreach ($print as $pre) {
                $a += ($pre->price * $pre->quantity) - ($pre->price * ($pre->p_discount / 100));
            }
            echo $a . get_currencySymbols();
            ?>
        </p>
    </div>
    </hr>
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