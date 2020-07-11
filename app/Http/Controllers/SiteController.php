<?php

namespace App\Http\Controllers;

use App\Mail\SupportShipped;
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
        Mail::to(config('mail.from.address'))->send(new SupportShipped($request));

        return response(['status' => 200]);
    }
}
