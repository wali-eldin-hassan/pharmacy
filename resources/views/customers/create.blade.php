@extends('layouts.app')
@section('title', '| Add new customer')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('customers.newcustomers')
        </div>
        <div class="panel-body">
            {{ Form::open(['route' => 'customers.store', 'class' => 'form-horizontal']) }}
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('name' , trans('customers.name'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::text('name', null, ['class'=>'form-control', 'placeholder' => trans('customers.name')])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('address' , trans('customers.address'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::text('address', null, ['class'=>'form-control', 'placeholder' => trans('customers.address')])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('phone' , trans('customers.phone'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::text('phone', null, ['class'=>'form-control', 'placeholder' => trans('customers.phone')])}}
                    </div>
                </div>

                <div class="form-group">
                    {{Form::label('info' , trans('customers.info'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::textarea('info', null, ['class'=>'form-control','id' => 'textarea',  'placeholder' => trans('customers.info')])}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Trigger the modal with a button -->
                <button class="btn btn-info btn-lg" data-target="#salesModel" data-toggle="modal"
                        type="button">@lang('button.order')</button>
                <!-- Modal -->
                <div class="modal fade" id="salesModel" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">×</button>
                                <h4 class="modal-title">@lang('sell.drugs')</h4>

                                <div id="custom-search-input" class="col-md-4">
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control input-md" id="SearchProducts"
                                               name="search" placeholder="@lang('products.search')"/>
                                        <span class="input-group-btn">
                                      <button class="btn btn-info btn-md" type="button">
                                          <i class="fa fa-search" aria-hidden="true"></i>
                                       </button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body" id="salesModelBody">
                                @foreach($product as $pro)
                                    <button class="btn btn-white" data-discount="{{$pro->p_discount}}"
                                            data-id="{{$pro->p_id}}" data-price="{{$pro->p_price}}">
                                        @if($pro->p_icon !== NULL)
                                            <img src="{{asset('img').'/'.$pro->p_icon.'.png'}}" width="20">
                                        @endif
                                        {{$pro->p_gname}}
                                    </button>
                                @endforeach
                            </div> <!-- end div #salesModelBody -->
                            <div class="modal-body" style="display: none;" id="salesModelBodyAjax"></div>
                            <!-- end div #salesModelBodyAjax -->
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal"
                                        type="button">@lang('button.close')</button>
                            </div>
                        </div>
                    </div>
                </div>  <!-- end div #salesModel -->
            </div> <!-- end col 6 -->

            <div class="col-md-6">
                <div id="divOrder" style="display:none; ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @lang('sell.orderTitle')
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div id="divOrderPro">
                                    <span id="order"></span>
                                    <span id="totalPriceSpan">
                                        <strong>
                                            @lang('sell.totalPrice'):
                                        </strong>
                                        <small>
                                            {{get_currencySymbols() }}
                                        </small>
                                        <p id="totalPrice">
                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end fiv #divOrder -->
            </div> <!-- end col 6 -->
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button class="btn btn-info" type="submit"><i class="fa fa-plus-circle"
                                                                      aria-hidden="true"></i> @lang('button.create')
                        </button>
                    </div>
                </div>
            </div>    <!-- end col 12 -->
        </div> <!-- end div .panel-body -->
    {{ Form::close() }} <!-- end form !-->
    </div> <!-- end div .panel -->
    <script>


        /*

         Sell bootbox

         */

        // Function to remove product

        $(function () {
            $(document).on('click', '#deleteOrderProduct', function (e) {
                var id = $(this).attr('data-id');
                var p = $("#salesModelBody").find("[data-id='" + id + "']").removeClass('disabled');
                var _a = $(this).parent().find('#aDiscount').text();
                var _b = $('#totalPrice').text();
                if (_a > 0) {
                    $('#totalPrice').html((parseFloat(_b) - parseFloat(_a)).toFixed(2));
                    $(this).parent().fadeOut(200).remove();

                    if ($('#totalPrice').text() <= '0') {
                        $('#totalPrice').parents().find('#divOrder').fadeOut(200);
                    }
                }

            });
        });

        $(function () {
            $(document).on('click', '.modal-body button  ', function (e) {
                e.preventDefault();

                //disabled after choose
                if ($(this).hasClass('disabled')) {
                } else {
                    $(this).addClass('disabled');
                    var $value = $(this).attr('data-id');
                    var $price = $(this).attr('data-price');
                    var $discount = $(this).attr('data-discount');
                    var $name = $(this).text();
                    if ($discount !== '') {
                        var $_dis = (parseFloat($price) - (parseFloat($price) * (parseFloat($discount / 100)))).toFixed(2); // discount calc
                    } else {
                        $_dis = 0;
                    }
                    if ($('#aDiscount').text() === '') {  //calc price and put it in totalprice id
                        sum = $_dis;
                    } else {
                        var sum = $_dis;
                        $("[id=aDiscount]").each(function () {
                            sum = parseFloat(sum) + parseFloat($(this).text());
                        });
                    }
                    $('#totalPrice').html(sum);
                    $('#divOrder').show();
                    $('span#order').append(
                        '<div class="divOrderProduct">' +
                        '<i class="fa fa-times " aria-hidden="true" data-id="' + $value + '"id="deleteOrderProduct"></i>' +
                        '<ul>' +
                        '<li style="margin-bottom: 10px;"><span>' +
                        '<strong> @lang('sell.bname') : </strong>' + $name +
                        '</span></li>' +
                        '<input type="hidden" id="productID" name="productID[]" value="' + $value + '" /> ' +
                        '<input type="hidden" id="oldPrice" name="orderPrice[]" value="' + $price + '" />' +
                        '<li><span id="productPriceSpan"><strong> @lang('sell.price') :  </strong> <p id="productPrice" > <small"> {{get_currencySymbols() }} </small> ' + $price + '</p></span></li>' +
                        '<li><span id="productPriceSpan"><strong> @lang('sell.discount') :  </strong> <p id="productDiscount" >  ' + $discount + '%</p></span></li>' +
                        '<li><span id="productPriceSpan"><strong> @lang('sell.adiscount') :  </strong> <p id="aDiscount" >  ' + $_dis + '</p></span></li>' +
                        '<li><span id="quantityOrderSpan"><strong>@lang('sell.quantity') :  </strong> <input class="form-control" id="quantityOrder"  type="number" max="50" min="1" name="orderQuantity[]" value="1"> </span></li></ul>' +
                        '<textarea class="form-control" rows="2" id="productInfo" name="orderInfo[]" placeholder="@lang('sell.seffect')"></textarea>' +
                        '<hr></div>');
                }
            });

            //if quantity change clac price and put it in totalprice
            $(document).on('change', '#quantityOrder', function () {
                var $number = $(this).val();
                var $price = $(this).parent().parent().parent().find('#productPrice').text();
                var $orgPrice = $(this).parent().parent().parent().find('#oldPrice').val();
                var $discount = $(this).parent().parent().parent().find('#productDiscount').text();
                //if discount empty
                if ($discount.split(' ').join('') === '%') {
                    var $plus = (parseFloat($orgPrice) * parseFloat($number)).toFixed(2);
                    alert('sad');
                } else {
                    var $_dis = parseFloat($discount) / parseFloat('100') * parseFloat($orgPrice);
                    var $_dis2 = parseFloat($orgPrice) - parseFloat($_dis);
                    var $plus = (parseFloat($_dis2) * parseFloat($number)).toFixed(2);
                }
                $(this).parent().parent().parent().find('#productPrice').html('<small"> {{get_currencySymbols() }} </small>' + $plus);

                //total price after change quantity
                var suma = 0;
                $("[id=productPrice]").each(function () {
                    suma += parseFloat($(this).text());
                });
                $('#totalPrice').html(suma);

            });
            // Product search

            $("#SearchProducts").keyup(function () {
                var _search = $(this).val();

                //if search input is empty
                if (_search === '') {
                    $('#salesModelBodyAjax').hide();
                    $('#salesModelBody').show();
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: '/product/search',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'search': _search
                    },
                    success: function (data) {
                        $('#salesModelBody').hide();
                        $('#salesModelBodyAjax').show();
                        var $a = '';
                        $.each(data, function (i, result) {
                            $a += '<button class="btn btn-white" data-discount="' + result.p_discount + '" data-id="' + result.p_id + '" data-price="' + result.p_price + '">'
                            if (result.p_icon) {
                                $a += '<img src="../img/' + result.p_icon + '.png" width="20">'
                            }
                            $a += result.p_bname + '</button> '
                        });
                        $('#salesModelBodyAjax').html($a);
                    }
                });
            });

        });
    </script>
@endsection
