@extends('layouts.app')
@section('title', '| Printer')
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('setting.invoice')
            </div>
            <div class="panel-body">
                {{Form::model(get_setting() ,['route' => ['setting.printerUpdate' , get_setting()->id],'method' => 'PUT', 'class' => 'form-horizontal' ])}}
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('name' ,trans('setting.name'), ['class' => 'control-label col-sm-2'])}}
                        <div class="col-sm-10">
                            {{Form::text('name',  $printer->ph_name, ['class'=>'form-control', 'placeholder' => trans('setting.name')])}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('address' , trans('setting.address'), ['class' => 'control-label col-sm-2'])}}
                        <div class="col-sm-10">
                            {{Form::text('address',  $printer->ph_address, ['class'=>'form-control', 'placeholder' => trans('setting.address')])}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('telephone' , trans('setting.phone'), ['class' => 'control-label col-sm-2'])}}
                        <div class="col-sm-10">
                            {{Form::text('telephone',  $printer->ph_telephone, ['class'=>'form-control', 'placeholder' => trans('setting.phone')])}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('fax' , trans('setting.fax'), ['class' => 'control-label col-sm-2'])}}
                        <div class="col-sm-10">
                            {{Form::text('fax', $printer->ph_fax, ['class'=>'form-control', 'placeholder' => trans('printer.fax') ])}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('email' , trans('setting.email'), ['class' => 'control-label col-sm-2'])}}
                        <div class="col-sm-10">
                            {{Form::text('email', $printer->ph_email, ['class'=>'form-control', 'placeholder' => trans('setting.email') ])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6" id="setting-invoice">
                    <div class="form-group text-center">
                        <button class="btn btn-default" data-id="1" id="pstyle">
                            B&W
                        </button>
                        <button class="btn btn-danger" data-id="2" id="pstyle">
                            Colors
                        </button>
                        <button class="btn btn-danger" data-id="3" id="pstyle">
                            Trint B&W
                        </button>
                        <button class="btn btn-danger" data-id="4" id="pstyle">
                            Trint colors
                        </button>
                        <input id="inprint" name="inprint" type="hidden"/>
                    </div>
                    <!--
                        Print Style one
                        -->
                    @if(get_setting()->ph_print === '1')
                        <img alt="pstyle1" class="img-responsive" id="pstyle1"
                             src="{{asset('img/printstyle/pstyle1.png')}}"/>
                    @elseif(get_setting()->ph_print === '2')
                        <img alt="pstyle2" class="img-responsive" id="pstyle2"
                             src="{{asset('img/printstyle/pstyle2.png')}}"/>
                        </img>
                    @elseif(get_setting()->ph_print === '3')
                        <img alt="trint" class="img-responsive" id="trint" src="{{asset('img/printstyle/trint.png')}}"/>

                    @elseif(get_setting()->ph_print === '4')
                        <img alt="trint_colors" class="img-responsive" id="trint_colors"
                             src="{{asset('img/printstyle/trint_colors.png')}}"/>
                    @endif

                    <img alt="pstyle1" class="img-responsive" id="pstyle1" src="{{asset('img/printstyle/pstyle1.png')}}"
                         style="display: none;"/>
                    <img alt="pstyle2" class="img-responsive" id="pstyle2" src="{{asset('img/printstyle/pstyle2.png')}}"
                         style="display: none;"/>
                    <img alt="trint" class="img-responsive" id="trint" src="{{asset('img/printstyle/trint.png')}}"
                         style="display: none;"/>
                    <img alt="trint_colors" class="img-responsive" id="trint_colors"
                         src="{{asset('img/printstyle/trint_colors.png')}}" style="display: none;"/>


                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-2 col-xs-offset-1">
                            <button class="btn btn-info" id="btnSetting" name="button" type="submit">
                                <i class="fa fa-pencil" aria-hidden="true"></i> @lang('button.update')
                            </button>
                        </div> <!-- end col 2 -->
                    </div>
                </div> <!-- end col 12 -->
            </div> <!-- end div .panel-body -->
        {{Form::close()}} <!-- end form -->
        </div> <!-- end div .panel -->
    </div> <!-- end col 12 -->
@endsection
