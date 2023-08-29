<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PMS') }} @yield('title')</title>

    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon">

    <!-- JS -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/plugins/toastr.min.js')}} " type="text/javascript"></script>
    <script src="{{asset('js/plugins/print.js')}}" type="text/javascript"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('js/plugins/Trumbowyg/dist/ui/trumbowyg.min.css')}}">

    @if(get_setting()->color === 'white' )
        <link href="{{ asset('css/white_main.css') }}" rel="stylesheet">
    @elseif(get_setting()->color === 'black')
        <link href="{{ asset('css/black_main.css') }}" rel="stylesheet">
    @endif
</head>
