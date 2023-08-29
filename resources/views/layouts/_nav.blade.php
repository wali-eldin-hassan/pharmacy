<div id="app">
    <div id="cover"></div> <!-- end div #cover -->

    @if(Auth::user())
        <nav class="navbar navbar-info navbar-static-top navbar-fixed ">
            <div class="navbar-header col-md-offset-1 col-sm-offset-1">
                <!-- Collapsed  -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.png')}}" width="110">
                </a>
            </div>

            <div class="col-md-4 col-sm-5 col-md-offset-2 col-sm-offset-2 " id="searchBox">
                <div id="custom-search-input">
                    <div class="input-group ">
                        <input type="text" class="form-control input-md" v-model="search"
                               autocomplete="off" id="Search" name="search" placeholder="@lang('navbar.search')"/>
                        <span class="input-group-btn">
                    <button class="btn btn-info btn-md" type="button">
                     <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </span>
                    </div>
                </div>
                <div class="col-md-10" id="resultSearchBox"
                ">
            </div>
</div>  <!-- end div #searchDiv -->
<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    <ul class="nav navbar-nav">
        &nbsp;
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        <li class="dropdown" id="logout">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <span class="fa fa-user-circle-o"></span>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{url('/account')}}"><span class="fa fa-edit"></span> @lang('navbar.account')</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                        <span class="fa fa-sign-out"></span>
                        @lang('navbar.logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>

        <!-- Phone only -->
        <ul class="nav navbar-nav navbar-right nav-menu-phone hidden-lg hidden-md hidden-lg hidden-md hidden-lg hidden-md hidden-sm">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-medkit fa-2x">
                    </i>
                    <p class="hidden-lg hidden-md hidden-sm">@lang('navbar.products')<span class="caret"></span></p></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="{{ set_active(['product', '/prodcut']) }}"><a href="{{ url('product') }}"><i
                                    class="fa fa-pencil fa-2x" aria-hidden="true"></i>
                            <p>  @lang('navbar.manage') </p></a></li>
                    <li class="{{ set_active(['product', '/prodcut/outstock']) }}"><a
                                href="{{ url('/product/outstock') }}"><i class="fa fa-archive fa-2x"
                                                                         aria-hidden="true"></i>
                            <p>  @lang('navbar.outstock')  </p>
                            <span id="notif-circle"><p>{{outStockCount()}}</p></span></a></li>
                    <li class="{{ set_active(['product', '/prodcut/expired']) }}"><a
                                href="{{ url('/product/expired') }}"><i class="fa fa-exclamation-circle fa-2x"
                                                                        aria-hidden="true"></i>
                            <p> @lang('navbar.outstock')</p><span id="notif-circle"><p>{{expiredCount()}}</p></span>
                        </a></li>
                </ul>
            </li>
            <li class="{{ set_active(['sales', 'sales/*']) }}"><a href="{{url('/sales/create')}}"><i
                            class="fa fa-money fa fa-2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.sell')</p></a></li>
            <li class="{{ set_active(['sales', 'sales/*']) }}"><a href="{{url('/sales')}}"><i
                            class="fa fa-cart-plus fa -2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.sales')</p></a></li>
            <li class="{{ set_active(['category', 'category/*']) }}"><a href="{{url('/category')}}"><i
                            class="fa fa-list  fa-2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.category')</p></a></li>
            <li class="{{ set_active(['suppliers', 'suppliers/*']) }}"><a href="{{url('/suppliers')}}"><i
                            class="fa fa-truck  fa-2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.provider')</p></a></li>
            <li class="{{ set_active(['customers', 'customers/*']) }}"><a href="{{url('/customers')}}"><i
                            class="fa fa-users  fa-2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.customers')</p></a></li>
            <li class="{{ set_active(['users', 'users/*']) }}"><a href="{{url('/users')}}"><i
                            class="fa  fa-user-md fa-2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.users')</p></a></li>
            <li class="{{ set_active(['analysis', 'analysis/*']) }}"><a href="{{url('/analysis')}}"><i
                            class="fa  fa-line-chart fa-2x" aria-hidden="true"></i>
                    <p class="hidden-lg hidden-md hidden-sm">  @lang('navbar.analysis')</p></a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-puzzle-piece fa fa-2x">
                    </i>
                    <p class="hidden-lg hidden-md hidden-sm">@lang('navbar.tools')<span class="caret"></span></p></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="{{ set_active(['tools', 'tools/*']) }}"><a href="{{url('/tools/discount')}}"><i
                                    class="fa  fa-sort-amount-desc fa fa-2x" aria-hidden="true"></i>
                            <p>  @lang('navbar.discount')</p></a></li>
                    <li class="{{ set_active(['tools', 'tools/*']) }}"><a href="{{url('/tools/note')}}"><i
                                    class="fa fa-sticky-note-o fa fa-2x" aria-hidden="true"></i>
                            <p>  @lang('navbar.note')</p></a></li>
                    <li class="{{ set_active(['tools', 'tools/*']) }}"><a href="{{url('/tools/dsearch')}}"><i
                                    class="fa fa-search fa fa-2x" aria-hidden="true"></i>
                            <p>  @lang('navbar.dsearch')</p></a></li>
                </ul>
            </li>
            <li class="dropdown" id="settingNav">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sliders fa fa-2x">
                    </i>
                    <p class="hidden-lg hidden-md hidden-sm">@lang('navbar.setting')<span class="caret"></span></p></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="{{ set_active(['setting', 'setting/*']) }}"><a href="{{url('/setting/lt')}}"><i
                                    class="fa fa-globe fa-2x" aria-hidden="true"></i>
                            <p>  @lang('navbar.lt')</p></a></li>
                    <li class="{{ set_active(['setting', 'setting/*']) }}"><a href="{{url('/setting/printer')}}"><i
                                    class="fa fa-info-circle  fa-2x" aria-hidden="true"></i>
                            <p>  @lang('navbar.printer')</p></a></li>
                    <li class="{{ set_active(['setting', 'setting/*']) }}"><a href="{{url('/setting/other')}}"><i
                                    class="fa fa-barcode  fa-2x" aria-hidden="true"></i>
                            <p> @lang('navbar.other')</p></a></li>
                    <li class="{{ set_active(['setting', 'setting/*']) }}"><a href="{{url('/setting/backup')}}"><i
                                    class="fa fa-cloud  fa-2x" aria-hidden="true"></i>
                            <p> @lang('navbar.backup')</p></a></li>

                </ul>
            </li>
        </ul>
    </ul>
    <!-- End phone -->
    @endif
</div>
</nav> <!-- end nav -->
