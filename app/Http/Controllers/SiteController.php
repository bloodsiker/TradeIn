<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mail;

/**
 * Class SiteController
 */
class SiteController extends Controller
{

    public function index()
    {
        return view('site.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAbout()
    {
        $data_seo = json_decode(DB::table('seo_meta')->where('title', 'about')->get());
        return view('site.about', compact('data_seo'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSupport()
    {
        $data_seo = json_decode(DB::table('seo_meta')->where('title', 'support')->get());
        return view('site.support', compact('data_seo'));
    }

    /**
     * @param Request $request
     */
    public function postSupport(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $comment = $request->comment;

        Mail::send('site.emails.support', compact('name', 'phone', 'comment'), function ($message){
            $message->from('info@boot.com.ua', 'BOOT');
            $message->to(config('mail.support_email'))->subject('Новый запрос со страницы Служба поддержки');
        });
    }
}
