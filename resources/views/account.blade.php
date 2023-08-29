@extends('layouts.app')
@section('title', '| Update account')

@section('content')

    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('account.title')</div>
            <div class="panel-body">
                {{Form::model (['route' => 'account.update', 'method' => 'PUT' ], ['class' => 'form-horizontal'] )}}
                <div class="form-group">
                    {{Form::label('name' , trans('account.name'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::text('name',Auth::user()->name, ['class'=>'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('email',trans('account.email'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::email('email',Auth::user()->email,['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('password',trans('account.password'), ['class' => 'control-label col-sm-2'])}}
                    <div class="col-sm-10">
                        {{Form::password('password',['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-info">@lang('button.update')</button>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

@endsection
