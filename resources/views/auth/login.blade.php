@include('layouts._head')
<div class="col-md-12" id="background-login">
    <img src="{{ asset('img/background-login.jpg') }}" alt="background-login" class="img-responsive"
        style="    height: 100vh;">
</div>
<div class="col-md-4 col-md-offset-4" id="login">
    <div class="panel panel-default">
        <div class="panel-heading"><img src="{{ asset('img/logo.png') }}" alt="logo" width="140"></div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} ">
                        <label for="email" class="control-label">@lang('login.email')</label>
                        <input id="email" type="email" class="form-control" name="email" value="admin@demo.com"
                            required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} ">
                        <label for="password" class="control-label">@lang('login.password')</label>

                        <input id="password" type="password" class="form-control" name="password" value="123123"
                            required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                @lang('login.remember')
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">
                            @lang('button.login')
                        </button>

                        <a class="btn btn-success" href="{{ route('password.request') }}">
                            @lang('button.forget')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layouts._javascript')
@include('layouts._footer')
