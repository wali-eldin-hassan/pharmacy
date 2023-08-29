@extends('layouts.app')
@section('title', '| Other')
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('setting.barcode')
            </div>
            <div class="panel-body">
                {{Form::model(get_setting() ,['route' => ['setting.otherUpdate' , get_setting()->id],'method' => 'PUT', 'class' => 'form-horizontal' ])}}
                <div class="col-md-offset-1 col-sm-offset-1">
                    <div class="form-group">
                        <div id="barcode-dropdown">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button">
                                    {{get_setting()->barcode_type}}
                                    <span class="caret"></span>
                                </button>
                                <input id="barcode" name="barcode" type="hidden"/>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">2D Barcodes</li>
                                    <li><a href="#">QRCODE</a></li>
                                    <li><a href="#">PDF417</a></li>
                                    <li><a href="#">DATAMATRIX</a></li>
                                    <li class="dropdown-header">1D Barcodes</li>
                                    <li><a href="#">C39</a></li>
                                    <li><a href="#">C39+</a></li>
                                    <li><a href="#">C39E</a></li>
                                    <li><a href="#">C39E+</a></li>
                                    <li><a href="#">C93</a></li>
                                    <li><a href="#">S25</a></li>
                                    <li><a href="#">S25+</a></li>
                                    <li><a href="#">I25</a></li>
                                    <li><a href="#">I25+</a></li>
                                    <li><a href="#">C128</a></li>
                                    <li><a href="#">C128A</a></li>
                                    <li><a href="#">C128B</a></li>
                                    <li><a href="#">C128C</a></li>
                                    <li><a href="#">EAN2</a></li>
                                    <li><a href="#">EAN5</a></li>
                                    <li><a href="#">EAN8</a></li>
                                    <li><a href="#">EAN13</a></li>
                                    <li><a href="#">UPCA</a></li>
                                    <li><a href="#">UPCE</a></li>
                                    <li><a href="#">MSI</a></li>
                                    <li><a href="#">MSI+</a></li>
                                    <li><a href="#">POSTNET</a></li>
                                    <li><a href="#">PLANET</a></li>
                                    <li><a href="#">RMS4CC</a></li>
                                    <li><a href="#">KIX</a></li>
                                    <li><a href="#">IMB</a></li>
                                    <li><a href="#">CODABAR</a></li>
                                    <li><a href="#">CODE11</a></li>
                                    <li><a href="#">PHARMA</a></li>
                                    <li><a href="#">PHARMA2T</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-info" id="btnSetting" name="button" type="submit"><i class="fa fa-pencil"
                                                                                                    aria-hidden="true"></i>@lang('button.update')
                        </button>
                    </div>
                </div>   <!-- end col-md-offset-1 -->
            </div>   <!-- end div .panel-body -->
        </div>   <!-- end div .panel -->
    {{Form::close()}}   <!-- end form -->
    </div>   <!-- end col 12 -->
@endsection
