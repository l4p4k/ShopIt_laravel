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
use App\Items_bought as Bought;

class CartController extends Controller
{

	/**
	* Create a new controller instance.
    * Guest can only add items to cart
	* @return void
	*/
    public function __construct()
    {
    	$this->middleware('auth', ['except' => ['mycart','add_to_cart','get_cart','cart_delete_item','delete_cart']]);
    }

    /*
    * View cart
    */
    public function mycart()
    {
        //get the cart
        $data = $this->get_cart();
        return view('mycart')->withdata($data);
    }

    /**
    * Get current cart items from database
    * @return cart details
    */
    public function get_cart()
    {
        //initialise variable
        $this_cart = null;
        //if session has a cart
        if(Session::has('cart'))
        {
            //for each item in the cart
            foreach(Session::get('cart') as $cart_item)
            {
                //get id of item from cart array from index 0
                $item_id = $cart_item['0']; 
                //get details of item with that id from database
                $item_data = Item::where('id', '=', $item_id)->first();
                //add to cart array
                $this_cart[] = $item_data;
            }
        }else{
            //no cart exists
        }
        //return cart
        return $this_cart;
    }

    /**
    * Add item to cart
    */
    public function add_to_cart(Request $request)
    {
        //get data input
        $item_id = $request->input('item_id');
        $quantity = $request->input('quantity');

    	//if cart exists in session
    	if (Session::has('cart')) 
    	{
            //get cart
    		$cart = session('cart');
            //make array of new item to be added
			$new_item_in_cart = array([$item_id,$quantity]);
			//merge to cart
			$cart = array_merge($cart, $new_item_in_cart);
            //put cart into session
    		Session::put('cart', $cart);
		}else{
            //if no cart exists make a new one
			$cart = array([$item_id,$quantity]);
			//put cart into session
    		Session::put('cart', $cart);
		}
        //open the cart page
        return Redirect::to('mycart');
    }


    /**
    * Delete item from cart
    */
    public function cart_delete_item($item_id)
    {
        //if cart exists
    	if (Session::has('cart')) 
    	{
            //get cart from session
    		$cart = session('cart');
            //get id of item in cart
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
            {//if last item was deleted remove cart from session
                Session::forget('cart');
            }

		}else
        {
            //if there already was no cart in session
		}
        //show cart page
        return Redirect::to('mycart');
    }

    /**
    * Delete cart
    */
    public function delete_cart()
    {
        //remove cart from session
    	Session::forget('cart');
        return Redirect::to('mycart');
    }    

    /**
    * Checkout with receipt
    */
    public function checkout()
    {
        //if cart exists
        if(Session::has('cart'))
        {
            //get cart
            $my_cart = Session::get('cart');
        }else
        {
            //cart is null and refresh page
            $my_cart = null;
            return $this->refresh();
        }

        //generate data to go on receipt
        $data = [
            //generate random code
            'code' => $this->generateRandomString(),
            //get item details of each item in cart
            'cart_details' => $this->get_cart(),
            //get the cart
            'my_cart' => $my_cart
        ];

        //instance of item table
        $item = new Item();
        //if data is not null and user is not guest
        if(($data != null) and (!Auth::guest()))
        {
            //loop through and check if all stock is there
            foreach ($data['cart_details'] as $key => $item) 
            {
                //get 1 item from cart (find from database)
                $item_info = $item::where('items.id', '=', $item->id)->first();
                //get quantity bought of that item
                $cart = $data['my_cart'];
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
                $cart = $data['my_cart'];
                $quantity = $my_cart[$key]['1'];

                DB::table('item_bought')->insert([
                    ['user_id' => Auth::user()->id, 'item_id' => $item->id, 'buy_quantity' => $quantity]
                ]);
                //take away from quantity
                $item_info->item_quantity = ($item_info->item_quantity)-$quantity;
                //save details
                $item_info->save();
            }
            //load the PDF receipt
            $pdf = PDF::loadView('receipt', $data);
            //remove cart
            Session::forget('cart');
            //show PDF
            return $pdf->stream();
        }else
        {//if no data is present
            //show error
            return Redirect::to('error');
        }
    }

    /**
    * Refresh page
    */
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
