@extends('layouts.app')
@section('title', '| Discount')
@section('content')
    <div class="col-md-offset-2 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"> @lang('tools.titlediscount') </div>

            <div class="panel-body">

                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2">@lang('tools.before')</label>
                        <div class="col-md-10">
                            <div class="input-discount-calc">
                                {{get_currencySymbols()}}
                                <input type="text" class="form-control" autocomplete="off" maxlength="14" id="before"
                                       placeholder="@lang('tools.price')">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2">@lang('tools.discount')</label>
                        <div class="col-md-10">
                            <div class="input-discount-calc">
                                <i id="discount-calc">%</i>
                                <input type="text" class="form-control" autocomplete="off" maxlength="14" id="discount"
                                       placeholder="@lang('tools.discount')">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2">@lang('tools.after')</label>
                        <div class="col-md-10">
                            <div class="input-discount-calc">
                                {{get_currencySymbols()}}
                                <input type="text" class="form-control" autocomplete="off" maxlength="14" id="after"
                                       maxlength="14" placeholder="@lang('tools.afterd')" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2">@lang('tools.save')</label>
                        <div class="col-md-10">
                            <div class="input-discount-calc">
                                {{get_currencySymbols()}}
                                <input type="text" class="form-control" id="saver" maxlength="14"
                                       placeholder="@lang('tools.save')" disabled>
                            </div>
                        </div>
                    </div>
                </form>  <!-- end forn-->
            </div>  <!-- end div .panel-->
        </div> <!-- end div .panel-->
    </div> <!-- end col 6 -->
@endsection
