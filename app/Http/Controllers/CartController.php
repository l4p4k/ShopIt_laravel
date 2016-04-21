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
use URL;

use App\Items as Item;

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

    public function mycart()
    {
        $data = $this->getCart();
        return view('mycart')->withdata($data);
    }

    /**
    * Get current cart items from database
    * @return cart details
    */
    public function getCart()
    {
        $item_from_db = null;
        $item = new Item();
        if(Session::has('cart'))
        {
            foreach(Session::get('cart') as $cart_item)
            {
                $item_id = $cart_item['0']; 
                $item_data = Item::where('id', '=', $item_id)->first();

                $item_from_db[] = $item_data;
            }
        }else{
        }
        return $item_from_db;
    }

    public function add_to_cart(Request $request)
    {

        $item_id = $request->input('item_id');
        $quantity = $request->input('quantity');

    	//if cart exists in session
    	if (Session::has('cart')) 
    	{
    		$cart = session('cart');
			$new_item_in_cart = array([$item_id,$quantity]);
			//merge to cart
			$cart = array_merge($cart, $new_item_in_cart);
			var_dump($cart);
    		Session::put('cart', $cart);
		}else{
			$cart = array([$item_id,$quantity]);
			var_dump($cart);
    		Session::put('cart', $cart);
		}
        return Redirect::to('mycart');
    }

    public function cart_delete_item($item_id)
    {
    	if (Session::has('cart')) 
    	{
    		$cart = session('cart');
            $cart_item = $cart[$item_id];
    		//remove element from index
    		unset($cart[$item_id]);
    		//reset index if cart exists
            if(isset($cart))
            {
                //make new cart with old values
    		    $new_cart = array_values($cart);

                //remove old array and insert new one to session
                Session::forget('cart');
                Session::put('cart', $new_cart);
            }else
            {
                Session::forget('cart');
            }

		}else{
		}
        return Redirect::to('mycart');
    }

    public function delete_cart()
    {
    	Session::forget('cart');
        return Redirect::to('mycart');
    }    

    public function checkout()
    {
        if(Session::has('cart'))
        {
            $my_cart = Session::get('cart');
        }else
        {
            $my_cart = null;
            return $this->refresh();
        }
        $data = [
            'code' => $this->generateRandomString(),
            'cart_details' => $this->getCart(),
            'my_cart' => $my_cart
        ];

        $item = new Item();
        if($data != null)
        {
            //loop through and check if all stock is there
            foreach ($data['cart_details'] as $key => $item) 
            {
                //get 1 item from cart (find from database)
                $item_info = $item::where('items.id', '=', $item->id)->first();
                //get quantity bought of that item
                $cart = Session::get('cart');
                $quantity = $my_cart[$key]['1'];
                //check if stock of item is not 0
                if($item_info->item_quantity == 0)
                {
                    $message = "There are no '".$item_info->item_name. "' left so it was removed from your cart";
                    //remove item from cart using $key of foreach loop
                    $cart_item = $cart[$key];
                    //remove element from index
                    unset($cart[$key]);
                    //reset index if cart exists
                    if(isset($cart))
                    {
                        //make new cart with old values
                        $new_cart = array_values($cart);

                        //remove old array and insert new one to session
                        Session::forget('cart');
                        Session::put('cart', $new_cart);
                    }else
                    {
                        Session::forget('cart');
                    }
                    return view('error')->withdata($message);
                }

            }
            //now take away from stock the amount you bought
            foreach ($data['cart_details'] as $key => $item) 
            {
                //get 1 item from cart (find from database)
                $item_info = $item::where('items.id', '=', $item->id)->first();
                //get quantity bought of that item
                $cart = Session::get('cart');
                $quantity = $my_cart[$key]['1'];

                //take away from quantity
                $item_info->item_quantity = ($item_info->item_quantity)-$quantity;
                //save details
                $item_info->save();
            }
        }

        $pdf = PDF::loadView('receipt', $data);
        Session::forget('cart');
        return $pdf->stream();
    }

    public function refresh()
    {
        return Redirect::back();
    }

    /**
    *   Create randomised transaction id
    */
    public function generateRandomString() 
    {
        //character set
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $randomString .= "SHOPIT";
        for ($i = 0; $i < 10; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
