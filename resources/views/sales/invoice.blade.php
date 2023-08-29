@extends('layouts.app')
@section('title', '| Sales')
@section('content')

    @if(get_setting()->ph_print === '1' || get_setting()->ph_print === '2')
        @include('invoice.1')
    @elseif(get_setting()->ph_print === '3' | get_setting()->ph_print === '4')
        @include('invoice.2')
    @endif

@endsection