<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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
        <th>@lang('print.customerno')</th>
        <th>@lang('print.name')</th>
        <th>@lang('print.address')</th>
        <th>@lang('print.telephone')</th>
        <th>@lang('print.info')</th>
        <th>@lang('print.saledate')</th>

    </tr>
    @foreach($customers as $customer)
        <tr>
            <td>{{$customer->number}}</td>
            <td>{{$customer->name}}</td>
            <td>{{$customer->address}}</td>
            <td>{{$customer->phone}}</td>
            <td>{{$customer->info}}</td>
            <td>{{$customer->created_at}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
