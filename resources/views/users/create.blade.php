@extends('layouts.app')
@section('title', '| Edit')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('users.create')
        </div>
        <div class="panel-body">
            {{ Form::open(['route' => 'users.store', 'class' => 'form-horizontal']) }}
            <div class="form-group">
                {{Form::label('name' ,trans('users.name'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('name' ,null, ['class'=>'form-control', 'placeholder' => trans('users.name')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('email' , trans('users.email'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('email',null, [ 'class'=>'form-control', 'placeholder' => trans('users.email')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('password' , trans('users.password'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('password',null, [ 'class'=>'form-control', 'placeholder' => trans('users.password')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('permission' ,trans('users.permission'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    <div class="togglebutton">
                        <label>
                            <input checked="" id="togglePermission" name="permission" type="checkbox" value="1"/>
                            @lang('users.superadmin')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-info" type="submit">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>@lang('button.create')
                    </button>
                </div>
            </div>
        {{ Form::close() }}
        <!-- end form -->
        </div>
        <!-- end div .panel-body -->
    </div>
    <!-- end div .panel -->
@endsection
