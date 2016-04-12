<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ini_set('xdebug.max_nesting_level', 200);
        $this->middleware('auth', ['except' => 'about']);
        $this->middleware('admin', ['only' => 'admindash']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function admindash()
    {
        // return "Hi admin ".Auth::user()->email;
        return view('admindash');
    }

}
