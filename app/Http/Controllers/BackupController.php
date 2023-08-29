<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user()->authorizeRoles(['superadmin']);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function backup(Request $request)
    {
        $backups = Storage::files('/backups/');
        return view('setting.backup', ['backups' => $backups]);
    }

    /*
     *  Create Backup
     */

    public function backupStore(Request $request)
    {
        if ($request->id === '1') {
            \Artisan::call('backup:run', ['--only-files' => true]);

            //get last one     
            $backups = Storage::files('/backups/');
            $last_backup = last($backups);
            return response([
                'msg' => 'Successful create backup files',
                'status' => 'success_files',
                'name' => $last_backup
            ]);
        } else {
            \Artisan::call('backup:run', ['--only-db' => true]);

            //get last one
            $backups = Storage::files('/backups/');
            $last_backup = last($backups);
            return response([
                'msg' => 'Successful create backup database',
                'status' => 'success_db',
                'name' => $last_backup
            ]);
        }

        return redirect()->route('setting.backup');
    }

    /*
     *  Download Backup
     */

    public function backupDownload($filename)
    {
        $file = Storage::disk('local')->get('backups/' . $filename);
        return response()->download(storage_path('app/backups/' . $filename));
    }

    /*
     *  Delete backup
     */
    public function backupDestroy(Request $request, $name)
    {
        if (Storage::disk('local')->exists('/backups/' . $name)) {
            Storage::delete('/backups/' . $name);
            return response(['msg' => 'Successful deleted' . $name . ' backup', 'status' => 'success']);
        }
        return response(['msg' => 'Failed deleting the ' . $name . ' backup', 'status' => 'failed']);
    }
}
