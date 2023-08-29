<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{
    public function index(Request $request, $locale)
    {
        Session::put('language', $locale);
        return redirect(url(URL::previous()));
    }
}
