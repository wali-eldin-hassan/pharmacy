<html>
<head>
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
        <th>@lang('print.gname')</th>
        <th>@lang('print.bname')</th>
        <th>@lang('print.country')</th>
        <th>@lang('print.idnumber')</th>
        <th>@lang('print.imdate')</th>
        <th>@lang('print.expire')</th>
        <th>@lang('print.price')</th>
        <th>@lang('print.orgprice')</th>
        <th>@lang('print.barcode')</th>
        <th>@lang('print.quantity')</th>
    </tr>
    @foreach($products as $product)
        <tr>
            <td>{{$product->p_gname}}</td>
            <td>{{$product->p_bname}}</td>
            <td>{{$product->p_country}}</td>
            <td>{{$product->p_idnumber}}</td>
            <td>{{$product->p_imdate}}</td>
            <td>{{$product->p_exdate}}</td>
            <td>{{$product->p_price}}</td>
            <td>{{$product->p_imprice}}</td>
            <td>{{$product->p_barcodeg}}</td>
            <td>{{$product->p_quantity}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
