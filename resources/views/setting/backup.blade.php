@extends('layouts.app')

@section('title', '| Other')
@section('content')
    <div class="col-md-12 ">
        <div class="col-md-4 col-md-offset-4" id="backup-loader" style="display:none;"></div>
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('setting.backup')
            </div>
            <div class="panel-body">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive" id="divBackupTable">
                        <table class="table table-responsive results">
                            <tr>
                                <th>
                                    @lang('setting.bkname')
                                </th>
                                <th>
                                    @lang('setting.control')
                                </th>
                            </tr>
                            <tbody id="backupDivBox">
                            @foreach($backups as $backup)
                                <tr>
                                    <td>
                                        {{ $backup }}
                                    </td>
                                    <td>
                                        <a href="{{route('backup.download', substr($backup,8))}}">
                                            <button class="btn btn-xs btn-success"><i class="fa fa-download"
                                                                                      aria-hidden="true"></i> @lang('button.download')
                                            </button>
                                        </a>
                                        {{Form::open(['route' => ['setting.backupDestroy', $backup], 'method' => 'DELETE' ,  'id' => 'deleteFormBackup'])}}
                                        {{Form::button('
                                        <i aria-hidden="true" class="fa fa-trash-o">
                                        </i>
                                        '. trans('button.delete'), ['class'=>'btn btn-xs btn-danger deleteBtnBackup', 'type'=>'submit', 'data-id' => $backup]) }}
                                        {{Form::close()}}
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>  <!-- end table  -->
                    </div>  <!-- end div #divProductTable  -->
                </div>  <!-- end col 12 -->
                {{Form::open (['route' => 'setting.backupStore' ,'class' => 'form-horizontal'] )}}
                <button class="btn btn-info" id="backupButton" data-id="1" type="submit">
                    <i class="fa fa-files-o" aria-hidden="true"></i> @lang('button.backupfiles')</button>
                <button class="btn btn-info" id="backupButton" data-id="2" type="submit">
                    <i class="fa fa-database" aria-hidden="true"></i> @lang('button.backupdatabase')</button>
                {{Form::close()}}

            </div> <!-- end div .panel-body -->
        </div>   <!-- end div .panel -->
    </div>   <!-- end col 12 -->
    <script>

        // backup function
        $(function () {
            $(document).on('click', '#backupButton', function (e) {
                e.preventDefault();
                var $type = $(this).attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: '/setting',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $type
                    },
                    beforeSend: function () {
                        $('#backup-loader').show();
                    },
                    complete: function () {
                        $('#backup-loader').hide();
                    },
                    success: function (msg) {
                        if (msg.status === 'success_files') {
                            bootbox.confirm({
                                title: "New backup",
                                message: 'tr>' + '<td>' + msg.name + '</td>' + '<td style="display: flex;">' + '<a href="http://127.0.0.1/setting/backup/get/' + msg.name.substr(8) + '"><button class="btn btn-xs btn-success"><i class="fa fa-download" aria-hidden="true"></i> @lang('button.download')</button></a>' + '<form method="POST" action="http://127.0.0.1/setting/backups/backups/' + msg.name.substr(8) + '" accept-charset="UTF-8" id="deleteFormBackup"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="' + $('input[name=_token]').val() + '">' + '<button class="btn btn-xs btn-danger deleteBtnBackup" type="submit" data-id="' + msg.name + '">' + '<i aria-hidden="true" class="fa fa-trash-o"></i> @lang('button.delete')</button>' + '</form>' + '</td>' + '</tr>',
                                buttons: {
                                    cancel: {
                                        label: '<i class="fa fa-times"></i> Cancel'
                                    },
                                    confirm: {
                                        label: '<i class="fa fa-check"></i> Confirm'
                                    }
                                },
                                callback: function (result) {
                                    console.log('This was logged in the callback: ' + result);
                                    window.location = ('/setting/backup')
                                }
                            });
                        } else if (msg.status === 'success_db') {
                            bootbox.confirm({
                                title: "New backup",
                                message: 'tr>' + '<td>' + msg.name + '</td>' + '<td style="display: flex;">' + '<a href="http://127.0.0.1/setting/backup/get/' + msg.name.substr(8) + '"><button class="btn btn-xs btn-success"><i class="fa fa-download" aria-hidden="true"></i> @lang('button.download')</button></a>' + '<form method="POST" action="http://127.0.0.1/setting/backups/backups/' + msg.name.substr(8) + '" accept-charset="UTF-8" id="deleteFormBackup"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="' + $('input[name=_token]').val() + '">' + '<button class="btn btn-xs btn-danger deleteBtnBackup" type="submit" data-id="' + msg.name + '">' + '<i aria-hidden="true" class="fa fa-trash-o"></i> @lang('button.delete')</button>' + '</form>' + '</td>' + '</tr>',
                                buttons: {
                                    cancel: {
                                        label: '<i class="fa fa-times"></i> Cancel'
                                    },
                                    confirm: {
                                        label: '<i class="fa fa-check"></i> Confirm'
                                    }
                                },
                                callback: function (result) {
                                    console.log('This was logged in the callback: ' + result);
                                    window.location = ('/setting/backup')
                                }
                            });
                            ;
                        }
                    },
                    error: function (data) {
                        if (data.status === 422) {
                            alert('error')
                        }
                    }
                })
            });
        });

    </script>
@endsection
