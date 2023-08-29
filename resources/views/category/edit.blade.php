@extends('layouts.app')
@section('title', '| Edit')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">@lang('category.edittitle') {{$category->name}}</div>
        <div class="panel-body">
            {{Form::model ($category, ['route' => ['category.update', $category->id], 'method' => 'PUT', 'class' => 'form-horizontal' ])}}
            <div class="form-group">
                {{Form::label('name' ,trans('category.name'),['class' => 'control-label col-sm-2'])}}
                <div class="col-sm-10">
                    {{Form::text('name', $category->name, ['class'=>'form-control', 'placeholder' => 'Category name'])}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-info"><i class="fa fa-pencil"
                                                                  aria-hidden="true"></i> @lang('button.update')
                    </button>
                </div>
            </div>
        {{Form::close()}}    <!-- end form -->

        </div> <!-- end div .panel-body -->
    </div>  <!-- end div .panel -->

@endsection
