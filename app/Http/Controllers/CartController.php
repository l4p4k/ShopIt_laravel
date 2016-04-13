<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Validator;
use Auth;
use DB;
use Session;


class CartController extends Controller
{

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
    public function __construct()
    {
    	$this->middleware('auth', ['except' => 'add_to_cart']);
    }

    public function add_to_cart(Request $request)
    {
    	//if cart exists in session
    	if ($request->session()->has('cart')) 
    	{
    		$cart = session('cart');

			$item_id = $request->input('item_id');
			$quantity = $request->input('quantity');
			$new_item_in_cart = array([$item_id,$quantity]);
			//merge to cart
			$cart = array_merge($cart, $new_item_in_cart);
			var_dump($cart);
    		$request->session()->put('cart', $cart);
		}else{
			$item_id = $request->input('item_id');
			$quantity = $request->input('quantity');
			$cart = array([$item_id,$quantity]);
			var_dump($cart);
    		$request->session()->put('cart', $cart);
		}
        return Redirect::to('mycart');
    }

    public function save_cart()
    {
        return Redirect::to('mycart');
    }    
}
