@if (Auth::user())
    <div class="container-fluid">
        <div class="col-md-1 col-sm-1 hidden-xs" id="sideNavbar">
            <div class="navbar navbar-inverse navbar-fixed-left">

                <ul class="nav navbar-nav">
                    <li class="{{ set_active(['/', '/*']) }}"><a href="{{url('/')}}" title=" @lang('navbar.dashboard')"
                                                                 data-toggle="tooltip"><i
                                    class="fa fa-tachometer fa fa-2x " aria-hidden="true"></i></a></li>
                    <li class="dropdown" title=" @lang('navbar.products')" data-toggle="tooltip">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-medkit fa fa-2x">
                            </i><span class="caret"></span></a>
                        @if(outStockCount() + expiredCount() !== 0)
                            <div class="col-md-1 col-md-offset-9 col-sm-offset-9" id="notif-circle-product">
                                <span><p>{{outStockCount() + expiredCount()}}</p></span>
                            </div>
                        @endif
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('product') }}"><i class="fa fa-pencil fa fa-2x" aria-hidden="true"></i>
                                    <p>  @lang('navbar.manage') </p></a></li>
                            <li><a href="{{ url('/product/outstock') }}"><i class="fa fa-archive fa fa-2x"
                                                                            aria-hidden="true"></i>
                                    <p>  @lang('navbar.outstock')</p>
                                    <span id="notif-circle"><p>{{outStockCount()}}</p></span></a></li>
                            <li><a href="{{ url('/product/expired') }}"><i class="fa fa-exclamation-circle fa-2x"
                                                                           aria-hidden="true"></i>
                                    <p>  @lang('navbar.outstock')</p><span
                                            id="notif-circle"><p>{{expiredCount()}}</p></span></a></li>
                            </a></li>
                        </ul>
                    </li>
                    <li class="{{ set_active(['sales', 'sales/*']) }}"><a href="{{url('/sales/create')}}"
                                                                          title="@lang('navbar.sell')"
                                                                          data-toggle="tooltip"><i
                                    class="fa fa-money fa fa-2x" aria-hidden="true"></i></a></li>
                    <li class="{{ set_active(['sales', 'sales/*']) }}"><a href="{{url('/sales')}}"
                                                                          title="@lang('navbar.sales')"
                                                                          data-toggle="tooltip"><i
                                    class="fa fa-cart-plus fa fa-2x" aria-hidden="true"></i></a></li>
                    <li class="{{ set_active(['category', 'category/*']) }}"><a href="{{url('/category')}}"
                                                                                title="@lang('navbar.category')"
                                                                                data-toggle="tooltip"><i
                                    class="fa fa-list fa fa-2x" aria-hidden="true"></i></a></li>
                    <li class="{{ set_active(['suppliers', 'suppliers/*']) }}"><a href="{{url('/suppliers')}}"
                                                                                  title="@lang('navbar.provider')"
                                                                                  data-toggle="tooltip"><i
                                    class="fa fa-truck fa fa-2x" aria-hidden="true"></i></a></li>
                    <li class="{{ set_active(['customers', 'customers/*']) }}"><a href="{{url('/customers')}}"
                                                                                  title="@lang('navbar.customers')"
                                                                                  data-toggle="tooltip"><i
                                    class="fa fa-users fa fa-2x" aria-hidden="true"></i></a></li>
                    <li class="{{ set_active(['analysis', 'analysis/*']) }}"><a href="{{url('/analysis')}}"
                                                                                title=" @lang('navbar.analysis')"
                                                                                data-toggle="tooltip"><i
                                    class="fa fa-line-chart fa-2x" aria-hidden="true"></i></a></li>
                    <li class="{{ set_active(['users', 'users/*']) }}"><a href="{{url('/users')}}"
                                                                          title="@lang('navbar.users')"
                                                                          data-toggle="tooltip"><i
                                    class="fa fa-user-md fa-2x" aria-hidden="true"></i></a></li>
                    <li class="dropdown">
                    <li class="dropup" title="@lang('navbar.tools')" data-toggle="tooltip">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="fa fa-puzzle-piece fa fa-2x">
                            </i><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{url('/tools/discount')}}"><i class="fa  fa-sort-amount-desc fa fa-2x"
                                                                        aria-hidden="true"></i>
                                    <p>  @lang('navbar.discount')</p></a></li>
                            <li><a href="{{url('/tools/note')}}"><i class="fa fa-sticky-note-o fa fa-2x"
                                                                    aria-hidden="true"></i>
                                    <p>  @lang('navbar.note')</p></a></li>
                            <li><a href="{{url('/tools/dsearch')}}"><i class="fa fa-search fa fa-2x"
                                                                       aria-hidden="true"></i>
                                    <p>  @lang('navbar.dsearch')</p></a></li>
                        </ul>
                    </li>
                    <li class="dropup" id="settingNav" title="@lang('navbar.setting')" data-toggle="tooltip">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sliders fa fa-2x">
                            </i><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{url('/setting/lt')}}"><i class="fa fa-globe fa fa-2x" aria-hidden="true"></i>
                                    <p>  @lang('navbar.lt')</p></a></li>
                            <li><a href="{{url('/setting/printer')}}"><i class="fa fa-info-circle fa fa-2x"
                                                                         aria-hidden="true"></i>
                                    <p>  @lang('navbar.printer')</p></a></li>
                            <li><a href="{{url('/setting/other')}}"><i class="fa fa-barcode fa fa-2x"
                                                                       aria-hidden="true"></i>
                                    <p> @lang('navbar.other')</p></a></li>
                            <li><a href="{{url('/setting/backup')}}"><i class="fa fa-cloud fa fa-2x"
                                                                        aria-hidden="true"></i>
                                    <p> @lang('navbar.backup')</p></a></li>

                        </ul>
                    </li>   <!-- end li #settingNav-->
                </ul>
            </div> <!-- end div .navbar -->
        </div> <!-- end div #sideNavbar -->

        @endif
        <div class="col-md-11 col-sm-11 col-xs-12 content">
            @yield('content')
        </div> <!-- end div #content -->
    </div> <!-- end div .container-fluid -->
