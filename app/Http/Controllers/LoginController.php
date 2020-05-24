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
                return redirect()->route('cabinet.main');
            }

            return redirect()->back()->with(['danger' => 'Не верные данные для входа']);
        }

        return view('site.auth.login');
    }

    public function resetPassword()
    {
        return view('site.auth.passwords.reset');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postServiceLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->roleSc()){
                $this->logService->log('Ввошел в кабинет сервисного центра');
                return redirect()->route('cabinet.dashboard');
            } elseif (Auth::user()->roleAdmin()){
                $this->logService->log('Ввошел в админский кабинет сервисного центра');
                return redirect()->route('cabinet.admin.user.list');
            }
            Auth::logout();
            return redirect()->back()->with(['message' => 'У Вас нету доступа в эту часть кабинета!']);
        }
        return redirect()->back()->with(['message' => 'Не верные данные для входа в личный кабинет!']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserLogin()
    {
        $data_seo = json_decode(DB::table('seo_meta')->where('title', 'user_login')->get());
        //dd(\Redirect::back()->getTargetUrl());
        return view('site.auth.signin_user', compact('data_seo'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUserLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);


        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->roleUser()){
                $this->logService->log('Ввошел в профиль');
                $prevPage = new ReturnToPreviousPage();
                return redirect()->to($prevPage->redirectToPrev());
            }
            Auth::logout();
            return redirect()->back()->with(['message' => 'У Вас нету доступа в эту часть кабинета!']);
        }
        return redirect()->back()->with(['message' => 'Не верные данные для входа в личный кабинет!']);
    }
}
