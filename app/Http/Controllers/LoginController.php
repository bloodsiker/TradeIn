<?php

namespace App\Http\Controllers;

use App\Mail\PasswordRecoveryShipped;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;

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

    /**
     * Ajax auth
     */
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

    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('email', $request->get('email'))->first();
            if ($user) {
                $user->remember_token = Str::random(60);
                $user->email_verified_at = Carbon::now()->add(1, 'day');
                $user->save();

                $url = route('password.recovery', ['remember_token' => $user->remember_token]);

                Mail::to($user->email)
                    ->send(new PasswordRecoveryShipped($user, $url));

                return redirect()->route('verify');
            }

            return redirect()->back()->with(['danger' => "Пользователя с email {$request->get('email')} не найдено"]);
        }

        return view('site.auth.passwords.reset');
    }

    public function verify()
    {
        return view('site.auth.passwords.verify');
    }

    public function passwordRecovery(Request $request)
    {
        $token = $request->get('remember_token');
        $errorToken = false;
        $emptyToken = true;

        if ($token) {
            $emptyToken = false;
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                if (Carbon::parse($user->email_verified_at)->timestamp < Carbon::now()->timestamp) {
                    $errorToken = true;
                }
            }
        }

        if ($request->isMethod('post')) {
            if ($request->password !== $request->password_confirm) {
                return redirect()->back()->with(['danger' => 'Пароли не совпадают']);
            }

            $user = User::where('remember_token', $token)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::login($user);

            return redirect()->route('cabinet.main');
        }

        return view('site.auth.passwords.recovery', compact('errorToken', 'emptyToken'));
    }
}
