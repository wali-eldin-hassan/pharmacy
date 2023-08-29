<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;

        }

        th, td {
            text-align: left;
            padding: 1px;
            word-break: break-all;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
    </style>
</head>
<body>


<h2>{{get_setting()->ph_name}}
    <dd style="float:right; font-size:10px;">{{date("F j, Y, g:i a")}}</dd>
</h2>

<table>
    <tr>
        <th>@lang('print.invoiceno')</th>
        <th>@lang('print.dname')</th>
        <th>@lang('print.tprice')</th>
        <th>@lang('print.saledate')</th>

    </tr>
    @foreach($sales as $sale)
        <tr>
            <td>{{$sale->invoice_no}}</td>
            <td>{{$sale->name}}</td>
            <td>{{floatval($sale->price)}}</td>
            <td>{{$sale->created_at}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
