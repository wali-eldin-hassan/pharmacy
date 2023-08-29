<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function Account()
    {
        return view('account');
    }

    /**
     * Update account
     *
     * @return void
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (!$request->input('password') == '') {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        session()->flash('success', 'Your account has been updated!');
        return redirect()->route('home');
    }
}
