@extends('layouts.app')
@section('title', '| Add new category')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">@lang('category.addtitle')</div>
        <div class="panel-body">
            {{Form::open (['route' => 'category.store',  'class' => 'form-horizontal' ])}}
            <div class="form-group">
                {{Form::label('name' , trans('category.name'), ['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('name', null, ['class'=>'form-control', 'placeholder' => trans('category.name')])}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-info">@lang('button.create')</button>
                </div>
            </div>
        {{Form::close()}}    <!-- end form -->
        </div>
    </div>

@endsection
