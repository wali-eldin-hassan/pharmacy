@extends('layouts.app')
@section('title', '| Show')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Show</div>

        <div class="panel-body">
            <div class="col-md-6" id="productShow">
                @foreach($product as $pro)
                    <h2>{{$pro->p_gname}}</h2>
                    <ul class="list-unstyled">
                        <li><strong>@lang('products.gname'): </strong> {{$pro->p_gname}}</li>
                        <li><strong>@lang('products.bname'): </strong> {{$pro->p_bname}}</li>
                    </ul>
                    <hr>
                    <h3>@lang('products.desc')</h3>
                    <p>{!! $pro->p_desc !!}</p>
                    <hr>
                    <h3>@lang('products.seffect')</h3>
                    <p>{!! $pro->p_seffect !!}</p>
                    <hr>
                    <p><strong>@lang('products.category'): </strong> {{$pro->name}}</p>
                    <p><strong>@lang('products.quantity'): </strong>
                        @if( $pro->p_quantity - $pro->sale_quantity < 4)
                            {{$pro->p_quantity - $pro->sale_quantity}} <span class="label label-danger">There is only
                                {{$pro->p_quantity - $pro->sale_quantity}} </span>
                        @else
                            {{$pro->p_quantity - $pro->sale_quantity}}
                        @endif
                    </p>
                    <p><strong>@lang('products.salePrice'): </strong>
                        <small> {{get_currencySymbols() }} </small> {{$pro->p_price}}</p>
                    <p><strong>@lang('products.provName'): </strong> {{$pro->p_imname}}</p>
                    <p><strong>@lang('products.orgPrice'): </strong>
                        <small> {{get_currencySymbols() }} </small> {{$pro->p_imprice}}</p>
                    <p><strong>@lang('products.discount'): </strong> {{$pro->p_discount}}%</p>
                    <p><strong>@lang('products.country'): </strong> {{$pro->p_country}}</p>
                    <p><strong>@lang('products.idp'): </strong> {{$pro->p_idnumber}}</p>
                    <p><strong>@lang('products.exdate') : </strong> {{ date('d-M-y', strtotime($pro->p_imdate ))  }}
                    </p>
                    <p><strong>@lang('products.imdate') : </strong> {{ date('d-M-y', strtotime($pro->p_exdate ))  }}
                    </p>
            </div>  <!-- end div #productShow -->

            <div class="col-md-6 text-center">
                <!--  Drug photo   -->
                <div class="col-md-12">
                    @if(!empty($pro->p_image))
                        <img src="{{asset('upload').'/'.$pro->p_image}}" data-toggle="tooltip"
                             title="{{$pro->p_bname}} Image " width="250">
                    @endif
                    <hr>
                </div> <!-- end col 12 -->
                <!--  Barcode   -->
                @if(!empty($pro->p_barcodeg) && get_setting()->barcode_type !== 'QRCODE' && get_setting()->barcode_type !== 'DATAMATRIX' && get_setting()->barcode_type !== 'PDF417')
                    <div class="col-md-12" style=" padding: 50px;">
                        {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("$pro->p_barcodeg ", get_setting()->barcode_type) . '" alt="barcode" width="220" data-toggle="tooltip" title=" Barcode " />' !!}
                        <p>{{$pro->p_barcodeg}}</p>
                    </div> <!-- end col 12-->
            </div>  <!-- end col 6 -->
            @elseif(!empty($pro->p_barcodeg))
                <div class="col-md-12" style="padding: 50px;">
                    {!! '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG("$pro->p_barcodeg ", get_setting()->barcode_type) . '" alt="barcode" width="220" data-toggle="tooltip" title=" Barcode " />' !!}
                    <p>{{$pro->p_barcodeg}}</p>
                </div>
        </div> <!-- end div .panel-body -->
        @endif
        @endforeach
    </div> <!-- end div .panel -->
    </div>
@endsection
