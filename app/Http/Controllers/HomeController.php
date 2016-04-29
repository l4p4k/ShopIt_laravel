<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Auth;
use DB;
use Session;

use App\Items as Item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * only admins can open admin dashboard
     * guests can open about page
     * @return void
     */
    public function __construct()
    {
        // ini_set('xdebug.max_nesting_level', 200);
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'admindash']);
    }

    public function admindash()
    {
        $item = new Item();
        $lowest_rated = $item->lowest_rated();
        $lowest_stock = $item->lowest_stock();
        $most_bulk = $item->most_bulk();
        // return var_dump($most_bulk);
        
        return view('admindash')
        ->with('lowest_rated',$lowest_rated)
        ->with('lowest_stock',$lowest_stock)
        ->with('most_bulk',$most_bulk);
    }



}
