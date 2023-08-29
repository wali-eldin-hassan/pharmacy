@extends('layouts.app')
@section('title', '| Create new supplied')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('supplied.addprov')</div>

        <div class="panel-body">
            {{ Form::open(['route' => 'suppliers.store', 'class' => 'form-horizontal']) }}
            <div class="form-group">
                {{Form::label('name' , trans('supplied.name'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('name', null, ['class'=>'form-control', 'placeholder' => trans('supplied.name')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('address' , trans('supplied.address'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('address', null, ['class'=>'form-control', 'placeholder' => trans('supplied.address')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('telephone' , trans('supplied.phone'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('telephone', null, ['class'=>'form-control', 'placeholder' => trans('supplied.phone')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('fax' , trans('supplied.fax'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('fax', null, ['class'=>'form-control', 'placeholder' => trans('supplied.fax')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('info' , trans('supplied.info'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::textarea('info', null, ['class'=>'form-control', 'id' => 'textarea', 'placeholder' => trans('supplied.info')])}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn  btn-info"><i class="fa fa-plus-circle"
                                                                   aria-hidden="true"></i> @lang('button.create')
                    </button>
                </div>
            </div>
        {{ Form::close() }} <!-- end form -->
        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel -->

@endsection
