@extends('layouts.app')
@section('title', '| Notes')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">@lang('tools.titlenote')</div>
        <div class="panel-body" id="noteDiv">
            <!-- Add -->
            {{Form::open(['route' => 'tools.noteStore', 'id' => 'noteAddForm'])}}
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('tools.note')
                        <div id="noteColorDropwdown">
                            <div class="dropdown">

                                <button class="btn btn-white btn-xs dropdown-toggle noteBtnColor"
                                        data-toggle="dropdown">@lang('tools.white')
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a data-type="White"><i class="fa fa-circle" aria-hidden="true"
                                                                style="color:white;"></i> White</a></li>
                                    <li><a data-type="Orange"><i class="fa fa-circle" aria-hidden="true"
                                                                 style="color:#FF5722;"></i> Orange</a></li>
                                    <li><a data-type="Blue"> <i class="fa fa-circle" aria-hidden="true"
                                                                style="color:#2196F3;"></i> Blue</a></li>
                                    <li><a data-type="Yellow"><i class="fa fa-circle" aria-hidden="true"
                                                                 style="color:#ffc521;"></i> Yellow</a></li>
                                    <li><a data-type="Black"><i class="fa fa-circle" aria-hidden="true"
                                                                style="color:#363636;"></i> Black</a></li>
                                </ul>
                            </div>
                        </div>  <!-- end div #noteColorDropwdown-->
                    </div>   <!-- end div .panel-heading -->
                    <div class="panel-body" id="noteContent">
                        <div class="form-group label-floating">
                            <label class="control-label"> @lang('tools.notename')</label>
                            <input class="form-control" id="noteName" name="noteName" maxlength="30" type="text"/>
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label">@lang('tools.note')</label>
                            <textarea class="form-control" id="noteText" cols="20"  maxlength="200" name="noteText"
                                      rows="5"> </textarea>
                        </div>
                        <button class="btn btn-white btn-xs" id="addNote">@lang('button.add')</button>
                    </div>  <!-- end div #noteContent-->
                </div>  <!-- end div .panel-->
            </div>  <!-- end col 3-->
            {{Form::close()}} <!-- end form -->
            <!-- Edit -->
            @foreach($note as $no)
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div id="noteColorDropwdown">
                                <div class="dropdown">
                                    <button class="btn btn-white btn-xs dropdown-toggle noteBtnColor"
                                            data-toggle="dropdown">
                                        @if($no->color === 'White')
                                            <i class="fa fa-circle" aria-hidden="true" style="color:white;"></i> White
                                        @elseif($no->color === 'Orange')
                                            <i class="fa fa-circle" aria-hidden="true" style="color:#FF5722;"></i>
                                            Orange
                                        @elseif($no->color === 'Blue')
                                            <i class="fa fa-circle" aria-hidden="true" style="color:#2196F3;"></i> Blue
                                        @elseif($no->color === 'Yellow')
                                            <i class="fa fa-circle" aria-hidden="true" style="color:#ffc521;"></i>
                                            Yellow
                                        @elseif($no->color === 'Black')
                                            <i class="fa fa-circle" aria-hidden="true" style="color:#363636;"></i> Black
                                        @endif
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a data-type="White"><i class="fa fa-circle" aria-hidden="true"
                                                                    style="color:white;"></i> White</a></li>
                                        <li><a data-type="Orange"><i class="fa fa-circle" aria-hidden="true"
                                                                     style="color:#FF5722;"></i> Orange</a></li>
                                        <li><a data-type="Blue"> <i class="fa fa-circle" aria-hidden="true"
                                                                    style="color:#2196F3;"></i> Blue</a></li>
                                        <li><a data-type="Yellow"><i class="fa fa-circle" aria-hidden="true"
                                                                     style="color:#ffc521;"></i> Yellow</a></li>
                                        <li><a data-type="Black"><i class="fa fa-circle" aria-hidden="true"
                                                                    style="color:#363636;"></i> Black</a></li>
                                    </ul>
                                </div>
                                <button type="button" rel="tooltip" title="Remove"
                                        class="btn btn-danger btn-simple btn-xs" id="btnNoteDelete" data-id={{$no->id}}>
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>  <!-- end div #noteColorDropwdown -->
                        </div>  <!-- end div .panel-heading -->
                        <div class="panel-body {{$no->color}}" id="noteContent">
                            <div class="form-group label-floating" style="margin: 0;">
                                <p class="noteName">{{$no->name}}</p>
                                <small class="noteDate">{{$no->created_at}}</small>
                            </div>
                            <div class="form-group label-floating" style="margin-top: 0px;">
                                <textarea class="form-control" id="noteText" cols="20" id="" maxlength="200"
                                          name="noteText" rows="5" >{{$no->content}} </textarea>
                            </div>
                            <button class="btn btn-white btn-xs" id="editNote"
                                    data-id="{{$no->id}}">@lang('button.edit')</button>
                        </div>
                    </div> <!-- end div #noteContent -->
                </div> <!-- end col 3 -->
            @endforeach
        </div> <!-- end div .panel-body -->
    </div> <!-- end div .panel -->

@endsection
