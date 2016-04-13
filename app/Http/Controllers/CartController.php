<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Validator;
use Auth;
use DB;
use Session;
use PDF;


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

    public function cart_delete_item($item_id)
    {
    	if (Session::has('cart')) 
    	{
    		$cart = session('cart');
    		//remove element from index
    		unset($cart[$item_id]);
    		//reset index
    		$new_cart = array_values($cart);

    		//remove old array and insert new one to session
    		Session::forget('cart');
    		Session::put('cart', $new_cart);

		}else{
		}
        return Redirect::to('mycart');
    }

    public function delete_cart()
    {
    	Session::forget('cart');
        return Redirect::to('mycart');
    }    

    public function checkout(){
        $pdf = PDF::loadHTML('<h3>Transaction id: '.$this->generateRandomString(30).'</h3>');
        Session::forget('cart');
        return $pdf->stream();
    }

    /**
    *   Create randomised transaction id
    */
    public function generateRandomString() {
        //character set
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $randomString .= "SHOPIT";
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
