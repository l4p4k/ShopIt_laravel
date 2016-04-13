<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use DB;
use Session;

use App\Items as Item;



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
    public function profile()
    {
        return view('profile');
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

    public function mycart()
    {
        $item = new Item();
        // $data = DB::table('items')->get();


        if(Session::has('cart'))
        {
            foreach(Session::get('cart') as $cart_item)
            {
                $item_id = $cart_item['0']; 
                $key = Item::where('item_id', '=', $item_id)->first();

                $data[] = $key;
            }
        }else{
            $data = null;
        }
        // var_dump(Session::get('cart'));
        return view('mycart')->withdata($data);
    }

}
