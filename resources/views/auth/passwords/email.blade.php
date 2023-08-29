@include('layouts._head')
<div class="col-md-12" id="background-login">
    <img src="{{asset('img/background-login.jpg')}}" alt="background-login" class="img-responsive"
         style="    height: 100vh;">
</div>
<div class="col-md-4 col-md-offset-4" id="forget">
    <div class="panel panel-default">
        <div class="panel-heading">@lang('login.rest')</div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">@lang('login.email')</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                               required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">
                            @lang('login.rest')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('layouts._javascript')
@include('layouts._footer')