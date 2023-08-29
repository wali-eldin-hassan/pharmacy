<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
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
    public function lt()
    {
        return view('setting.lt');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ltUpdate(Request $request, $id)
    {

        // If only language change

        $setting = Settings::find($id);

        if (!empty($request->language)) {
            $setting->language = $request->input('language');
        }
        if (!empty($request->color)) {
            $setting->color = $request->input('color');
        }
        if (!empty($request->currency)) {
            $setting->currency = $request->input('currency');
        }

        // If nothing change
        $setting->save();
        session()->flash('success', 'Successful change');
        return redirect()->route('setting.lt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printer()
    {
        $printer = Settings::all()->last();
        return view('setting.printer')->withprinter($printer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function printerUpdate(Request $request, $id)
    {
        $printer = Settings::find($id);
        $printer->ph_name = $request->name;
        $printer->ph_address = $request->address;
        $printer->ph_telephone = $request->telephone;
        $printer->ph_fax = $request->fax;
        $printer->ph_email = $request->email;
        $printer->ph_print = $request->inprint;
        $printer->save();

        session()->flash('success', 'Successful update');
        return redirect()->route('setting.printer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function other()
    {
        return view('setting.other');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function otherUpdate(Request $request, $id)
    {
        $other = Settings::find($id);
        $other->barcode_type = $request->barcode;
        $other->save();
        session()->flash('success', 'Successful update');
        return redirect()->route('setting.other');
    }
}
