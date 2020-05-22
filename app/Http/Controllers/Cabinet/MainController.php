<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

/**
 * Class MainController
 */
class MainController extends Controller
{

    public function index()
    {
        return view('cabinet.index');
    }
}
