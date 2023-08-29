@extends('layouts.app')
@section('title', '| Suppliers')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('supplied.title')</div>

        <div class="panel-body">
            <div id="tablePanel">
                <a href="{{url('/suppliers/create')}}">
                    <button class="btn btn-sm btn-info" data-id=""><i class="fa fa-plus-circle"
                                                                      aria-hidden="true"></i> @lang('supplied.addprov')
                    </button>
                </a>
            </div>  <!-- end div #tablePanel -->
            <hr> <!-- line -->
            @foreach ($suppliers as $prov)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div id="provideDiv">
                        <strong id="info">@lang('supplied.name')</strong>
                        <p>{{$prov->name}}</p>
                        <strong id="info">@lang('supplied.address')</strong>
                        <p>{{$prov->address}}</p>
                        <strong id="info">@lang('supplied.phone') </strong>
                        <p>{{$prov->phone}}</p>
                        <strong id="info">@lang('supplied.fax') </strong>
                        <p>{{$prov->fax}}</p>
                        <strong id="info">@lang('supplied.info')</strong>
                        <div style="color:#fff !important;">{!! $prov->info !!}</div>

                        <div class="btnProviderDiv">
                            <a href="{{route('suppliers.edit', $prov->id)}}">
                                <button class="btn btn-xs btn-white"><i class="fa fa-pencil"
                                                                        aria-hidden="true"></i> @lang('button.edit')
                                </button>
                            </a>
                            {{Form::open(['route' => ['suppliers.destroy', $prov->id], 'method' => 'DELETE' , 'id' => 'deleteFormProvider'])}}

                            {{Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> '. trans('button.delete'), ['class'=>'btn btn-xs btn-danger deleteBtnProvider', 'type'=>'submit', 'data-id' =>  $prov->id]) }}

                            {{Form::close()}}
                        </div>  <!-- end div #btnProviderDiv -->
                    </div>
                </div> <!-- end col-md-3 -->
            @endforeach

        </div>  <!-- end div #provideDiv -->
    </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel-->
@endsection
