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

    public function calculator()
    {
        return view('site.calculator');
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
