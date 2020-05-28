<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'email'    => 'required',
                'password' => 'required'
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                if (Auth::user()->is_active) {
                    return redirect()->route('cabinet.main');
                }

                Auth::logout();

                return redirect()->back()->with(['danger' => 'Пользователь заблокирован']);
            }

            return redirect()->back()->with(['danger' => 'Не верные данные для входа']);
        }

        return view('site.auth.login');
    }

    public function resetPassword()
    {
        return view('site.auth.passwords.reset');
    }

    public function auth(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'email'    => 'required',
                'password' => 'required'
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                if (Auth::user()->is_active) {
                    return response(['status' => 1, 'message' => 'Authentication success']);
                }

                Auth::logout();

                return response(['status' => 0, 'message' => 'Пользователь заблокирован']);
            }

            return response(['status' => 0, 'message' => 'Не верные данные для входа']);
        }

        return response(['status' => 0, 'message' => 'Bad request method']);
    }
}
