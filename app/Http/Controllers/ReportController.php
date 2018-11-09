<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function __construct(){

    }
    public function index()
    {
        return view('dashboard/management/report/index');
    }
}
