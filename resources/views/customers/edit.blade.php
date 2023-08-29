@extends('layouts.app')
@section('title', '| Edit')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('customers.editcust') {{$customers->name}}</div>

        <div class="panel-body">
            {{ Form::model($customers, ['route' => ['customers.update', $customers->id],  'method' => 'PUT', 'class' => 'form-horizontal'  ])}}
            <div class="form-group">
                {{Form::label('name' ,trans('customers.name'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('name',  $customers->name, ['class'=>'form-control', 'placeholder' => trans('customers.name')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('address' , trans('customers.address'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('address',  $customers->address, ['class'=>'form-control', 'placeholder' => trans('customers.address')])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('phone' , trans('customers.phone'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('phone',  $customers->phone, ['class'=>'form-control', 'placeholder' => trans('customers.phone')])}}
                </div>
            </div>

            <div class="form-group">
                {{Form::label('info' , trans('customers.info'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::textarea('info',  $customers->info, ['class'=>'form-control','id' => 'textarea',  'placeholder' => trans('customers.info')])}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn  btn-info"><i class="fa fa-pencil"
                                                                   aria-hidden="true"></i> @lang('button.update')
                    </button>
                </div>
            </div>
        {{ Form::close() }} <!--end form !-->
        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel -->

@endsection
