<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * return the view layouts/home/index
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('layouts/home/index');
    }
}
