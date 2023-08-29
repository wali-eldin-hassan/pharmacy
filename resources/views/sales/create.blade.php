@extends('layouts.app')
@section('title', '| Sell')
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('sell.title')</div>
            <div class="panel-body" id="divProduct">
                <div class="col-xs-12">
                    <div id="custom-search-input" class="col-md-4">
                        <div class="input-group col-md-12">
                            <input type="text" class="form-control input-md" autocomplete="off" id="SearchProducts"
                                   name="search" placeholder="@lang('products.search')"/>
                            <span class="input-group-btn"><button class="btn btn-info btn-md" type="button"><i
                                            class="fa fa-search" aria-hidden="true"></i></button></span>
                        </div>
                    </div>
                </div>
                <div id="salesModelBody">
                    @foreach($product as $pro)
                        <button class="btn btn-white" data-placement="bottom" data-html="true" data-toggle="tooltip"
                                title="<h4 class='text-left'>@lang('sales.description')</h4><br>
                        <p class='text-left'>{{str_limit($pro->p_desc,400)}}</p>
                        <h4 class='text-left'>@lang('products.seffect')</h4><br>
                        <p class='text-left'>{{str_limit($pro->p_seffect,400)}}</p>"
                                data-discount="{{$pro->p_discount}}" data-id="{{$pro->p_id}}"
                                data-price="{{$pro->p_price}}">
                            @if($pro->p_icon !== NULL)
                                <img src="{{asset('img').'/'.$pro->p_icon.'.png'}}" width="20">
                            @endif
                            {{$pro->p_bname}}
                        </button>
                    @endforeach
                </div>
                <div id="salesModelBodyAjax"></div>
            </div>
        </div>
        <!-- Icon order button -->
        <div id="divIconOrder" style="display: none;">
            <div class="col-md-1 col-md-offset-9 col-sm-offset-9" id="notif-circle-order">
                <span><p>0</p></span>
            </div>
            <button id="iconOrder" class="btn btn-danger btn-fab btn-round">
                <i class="fa fa-shopping-basket"></i>
            </button>
        </div>
        <div class="col-md-4 pull-right" id="divOrder" style="display: none;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('sell.orderTitle')
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        {{Form::open(['route' => 'sales.store' , 'id' => 'orderForm'])}}
                        <div id="divOrderPro">
                            <span id="order"></span>
                            <span id="totalPriceSpan">
                                    <strong> @lang('sell.totalPrice'):</strong>
                                    <small>{{get_currencySymbols() }}</small>
                                    <p id="totalPrice"></p>
                                </span><br>
                            <button class="btn btn-sm btn-danger" id="saleBtn"><i class="fa fa-cart-plus"
                                                                                  aria-hidden="true"></i>@lang('sell.sell')
                            </button>
                        </div> <!-- end div #divOrderPro -->
                        {{Form::close()}}
                    </div>  <!-- end form-->
                </div> <!-- end div .panel-body -->
            </div> <!-- end div .panel -->
        </div>  <!-- end div #divOrder -->
        <script>


            // Function to remove product

            $(function () {
                $(document).on('click', '#deleteOrderProduct', function (e) {
                    var $id = $(this).attr('data-id');
                    var $disabled = $("#salesModelBody").find("[data-id='" + $id + "']").removeClass('disabled');
                    var $discount = $(this).parent().find('#aDiscount').text();
                    var $tPrice = $('#totalPrice').text();
                    if ($discount > 0) {
                        $('#totalPrice').html((parseFloat($tPrice) - parseFloat($discount)).toFixed(2));
                        $(this).parent().fadeOut(200).remove();

                        //decrease when add new product to notifcation icon order
                        var $number = $('#notif-circle-order p').text(function (index) {
                            var $increase = $(this).text();
                            $increase--
                            $(this).text($increase);
                        });
                    }
                    // get total price after removed
                    // if total price = 0 hide orderbox
                    var $totalPrice2 = $('#totalPrice').text();
                    if (parseFloat($totalPrice2) === 0) {
                        $('#divOrder,#divIconOrder').hide();
                    }
                });
            });


            // This function to set the product in box order
            $(function () {

                //toggle box order if click to icon order button
                $(document).on('click', '#iconOrder', function () {
                    $('#divOrder').toggle();
                });

                $(document).on('click', '#divProduct button  ', function (e) {
                    e.preventDefault();

                    //disabled after choose
                    if (!$(this).hasClass('disabled')) {

                        //increase when add new product to notifcation icon order
                        var $number = $('#notif-circle-order p').text(function (index) {
                            var $increase = $(this).text();
                            $increase++
                            $(this).text($increase);
                        });

                        $(this).addClass('disabled');
                        var $id = $(this).attr('data-id');
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
                        $('#divIconOrder').show();
                        $('span#order').append(
                            '<div class="divOrderProduct">' +
                            '<i class="fa fa-times " aria-hidden="true" data-id="' + $id + '"id="deleteOrderProduct"></i>' +
                            '<ul>' +
                            '<li style="margin-bottom: 10px;"><span>' +
                            '<strong> @lang('sell.bname') : </strong>' + $name +
                            '</span></li>' +
                            '<input type="hidden" id="productID" name="productID[]" value="' + $id + '" /> ' +
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
                                $a += result.p_bname + '</button>'
                            });
                            $('#salesModelBodyAjax').html($a);
                        }
                    });
                });
            });
        </script>
@endsection

