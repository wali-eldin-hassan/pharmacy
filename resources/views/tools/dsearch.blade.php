@extends('layouts.app')
@section('title', '| Drugs search')
@section('content')
    <div class="col-md-offset-2 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('tools.titledsearch')
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="col-md-10">
                        <div class="form-group label-floating">
                            <label class="control-label"> @lang('tools.drug')</label>
                            <input class="form-control" id="getDrugsInformation" type="text">
                        </div>
                    </div>  <!-- end col 10-->
                    <button class="btn btn-info" id="p"><i class="fa fa-search" aria-hidden="true"></i>
                        @lang('button.search') </button>
                </form>  <!-- end form-->
            </div>  <!-- end div .panel-body-->
        </div>  <!-- end div .panel-->
    </div>  <!-- end  col 6 -->
@endsection
