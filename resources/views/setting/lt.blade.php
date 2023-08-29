@extends('layouts.app')
@section('title', '| Language & colors')
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('setting.titlelt')
            </div>
            <div class="panel-body">
            {{Form::model(get_setting() ,['route' => ['setting.ltUpdate' , get_setting()->id],'method' => 'PUT', 'class' => 'form-horizontal' ])}}
            <!--   Colors   -->
                <div class="form-group">
                    {{Form::label('colors',trans('setting.color'), ['class' => 'control-label col-sm-1'])}}
                    <div class="col-sm-2">
                        <div class="dropdown" id="color-dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                {{get_colors()}}
                                <span class="caret">
                            </span>
                            </button>
                            <input id="color_input" name="color" type="hidden"/>
                            <ul class="dropdown-menu">
                                <li>
                                    <a data-type="white" href="#">
                                        White
                                    </a>
                                </li>
                                <li>
                                    <a data-type="black" href="#">
                                        Black
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--   Currency   -->
                <div class="form-group">
                    {{Form::label('currency',trans('setting.currency'), ['class' => 'control-label col-sm-1'])}}
                    <div class="col-sm-2">
                        <div class="dropdown" id="currency-dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                {{get_currency()}}
                                <span class="caret">
                            </span>
                            </button>
                            <input id="currency_input" name="currency" type="hidden"/>
                            <ul class="dropdown-menu">
                                <li>
                                    <a data-type="dollar" href="#">
                                        <i class="fa fa-dollar ">
                                        </i>
                                        Dolar
                                    </a>
                                </li>
                                <li>
                                    <a data-type="euro" href="#">
                                        <i class="fa fa-euro ">
                                        </i>
                                        Euro
                                    </a>
                                </li>
                                <li>
                                    <a data-type="krw" href="#">
                                        <i class="fa fa-krw ">
                                        </i>
                                        KRW
                                    </a>
                                </li>
                                <li>
                                    <a data-type="gbp" href="#">
                                        <i class="fa fa-gbp ">
                                        </i>
                                        GBP
                                    </a>
                                </li>
                                <li>
                                    <a data-type="try" href="#">
                                        <i class="fa fa-try ">
                                        </i>
                                        Turkish Lira
                                    </a>
                                </li>
                                <li>
                                    <a data-type="india" href="#">
                                        <img src="/img/currency/india-rupee-currency-symbol.png"  width="14"/>
                                        India ruble
                                    </a>
                                </li>
                                <li>
                                    <a data-type="russia" href="#">
                                        <img src="/img/currency/russia-ruble-currency-symbol.png" width="14"/>
                                        Russia ruble
                                    </a>
                                </li>
                                <li>
                                    <a data-type="aed" href="#">
                                        SAR
                                    </a>
                                </li>
                                <li>
                                    <a data-type="dn" href="#">
                                        AED
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>   <!-- end col 2 -->
                </div>
                <!--   Language   -->
                <div class="form-group">
                    {{Form::label('language',trans('setting.language'), ['class' => 'control-label col-sm-1'])}}
                    <div class="col-sm-2">
                        <div class="dropdown" id="language-dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                {{get_language()}}
                                <span class="caret">
                            </span>
                            </button>
                            <input id="language_input" name="language" type="hidden"/>
                            <ul class="dropdown-menu">
                                <li value="en">
                                    <a data-type="en" href="#">
                                        <img src="{{asset('img/US.png')}}">
                                        @lang('setting.english')
                                        </img>
                                    </a>
                                </li>
                                <li value="fr">
                                    <a data-type="fr" href="#">
                                        <img src="{{asset('img/FR.png')}}">
                                        @lang('setting.france')
                                        </img>
                                    </a>
                                </li>
                                <li value="es">
                                    <a data-type="es" href="#">
                                        <img src="{{asset('img/ES.png')}}">
                                        @lang('setting.espanol')
                                        </img>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>   <!-- end col 2 -->
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-xs-offset-1">
                        <button class="btn btn-info" id="btnSetting" name="button" type="submit">
                            <i class="fa fa-pencil" aria-hidden="true"></i> @lang('button.update')
                        </button>
                    </div>   <!-- end col 2 -->
                </div>
            </div>   <!-- end div .panel-body -->
        </div>   <!-- end div .panel -->
    </div>   <!-- end col 12 -->
    {{Form::close()}}
@endsection
