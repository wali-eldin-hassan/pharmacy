@extends('layouts.app')
@section('title', '| Edit')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('supplied.editprov') {{$suppliers->name}}</div>
        <div class="panel-body">
            {{ Form::model($suppliers, ['route' => ['suppliers.update', $suppliers->id],  'method' => 'PUT', 'class' => 'form-horizontal'  ])}}
            <div class="form-group">
                {{Form::label('name' ,trans('supplied.name'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('name',  $suppliers->name, ['class'=>'form-control', 'placeholder' => trans('supplied.name')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('address' , trans('supplied.address'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('address',  $suppliers->address, ['class'=>'form-control', 'placeholder' => trans('supplied.address')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('telephone' , trans('supplied.phone'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('telephone',  $suppliers->phone, ['class'=>'form-control', 'placeholder' => trans('supplied.phone')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('fax' , trans('supplied.fax'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('fax', $suppliers->fax, ['class'=>'form-control', 'placeholder' => trans('supplied.fax') ])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('info' , trans('supplied.info'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::textarea('info',  $suppliers->info, ['class'=>'form-control','id' => 'textarea', 'placeholder' => trans('supplied.info')])}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn  btn-info"><i class="fa fa-pencil"
                                                                   aria-hidden="true"></i> @lang('button.update')
                    </button>
                </div>
            </div>
        {{ Form::close() }} <!-- end form -->
        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel -->

@endsection
