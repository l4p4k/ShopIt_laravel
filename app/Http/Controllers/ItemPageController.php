<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ItemPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ini_set('xdebug.max_nesting_level', 200);
        $this->middleware('auth', ['only' => 'item_edit']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function item_page()
    {
        return "You can see item details here";
        // return view('home');
    }
    public function item_edit()
    {
        return "Admins edit this item here";
    }
}
