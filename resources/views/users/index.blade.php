@extends('layouts.app')
@section('title', '| Users')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">@lang('navbar.users')</div>

        <div class="panel-body">
            <div id="tablePanel">
                <a href="{{url('/users/create')}}">
                    <button class="btn btn-sm btn-info" data-id=""><i class="fa fa-plus-circle"
                                                                      aria-hidden="true"></i> @lang('users.add')
                    </button>
                </a>
            </div>  <!-- end div #tablePanel -->
            <div class="col-md-12 col-sm-12  col-xs-12">
                <div class="table-responsive" id="divProductTable">
                    <table class="table table-hover results">
                        <tr>
                            <th>@lang('users.name')</th>
                            <th>@lang('users.email')</th>
                            <th>@lang('users.permission')</th>
                            <th>@lang('users.created_at')</th>
                            <th>@lang('users.updated_at')</th>
                            <th>@lang('users.control')</th>
                        </tr>
                        <tbody id="productDivBox">
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <span class="label label-danger">@if($user->roles_id === 1) @lang('users.superadmin')@else @lang('users.admin') @endif </span>
                                </td>
                                <td>{{date('d-M-Y-g:i',strtotime($user->created_at))}}</td>
                                <td>{{date('d-M-Y-g:i',strtotime($user->created_at))}}</td>
                                <td>
                                    <a href="{{route('users.edit', $user->id)}}">
                                        <button class="btn btn-xs btn-white"><i class="fa fa-pencil"
                                                                                aria-hidden="true"></i> @lang('button.edit')
                                        </button>
                                    </a>

                                    {{Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE' , 'id' => 'deleteUsersForm'])}}

                                    {{Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> '.trans('button.delete'), ['class'=>'btn btn-xs btn-danger deleteUsers', 'type'=>'submit', 'data-id' => $user->id]) }}

                                    {{Form::close()}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table> <!-- end tbody #productDivBox -->

                </div> <!-- end div #divProductTable -->
            </div>  <!-- end col 12 -->

        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel-->
@endsection
