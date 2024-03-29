<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Validator;
use Auth;
use DB;
use Session;
use URL;

use Illuminate\Support\Facades\Input as Input;
use App\Items as Item;
use App\Item_bought as Bought;
use App\rating as Rating;

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
     * Show the item page.
     *
     */
    public function item_page($id)
    {
        $item = new Item();
        //get details of item with id
        $data = $item->show_item_with_id($id);
        $rating = new Rating();
        //get rating of item
        $item_rating_count = $rating->get_item_rating_count($id);

        //if user is not guest
        if(!Auth::guest())
        {
            $bought = new Bought();
            //get user id
            $user_id = Auth::user()->id;
            //check if user has bought item before
            $if_bought = $bought->has_bought($user_id,$id);
            //check if user can rate
            $can_rate = $bought->can_rate($user_id, $id);
            //clear sessions (for quick refresh)
            Session::forget('rating'); 
            Session::forget('bought'); 
            //if user has rated
            if($can_rate != null)
            {
                //put rating of user into session
                $user_rating = $can_rate->rating;
                Session::put('rating', $user_rating); 
            }
            //if user has bought item before
            if($if_bought != null)
            {
                //put true/false if user has bought item before
                Session::put('bought', $if_bought);
            } 
            //show itempage with ratings
            return view('itemView')->withdata($data)->with('ratings', $item_rating_count); 
        }
        //show itempage with ratings
        return view('itemView')->withdata($data)->with('ratings', $item_rating_count); ;
    }

    /**
    * Rate a product
    */
    public function rate(Request $request)
    {
        //if user is not guest
        if(!Auth::guest()){  
            //get user id
            $user_id = Auth::user()->id;
            //get data from post
            $item_id = $request->input('item_id');
            $my_rating = $request->input('rating');

            $bought = new Bought();
            //check if user has not rated item
            if($bought->can_rate($user_id, $item_id) == null)
            {   
                //insert user's rating
                DB::table('rating')->insert([
                    ['user_id' => Auth::user()->id, 'item_id' => $item_id, 'rating' => $my_rating]
                ]);

                $rating = new Rating();
                //get average rating
                $avg_rating = $rating->avg_rating($item_id);
                //update items.rating column
                $rating->update_item_rating($item_id, $avg_rating);
                //refresh
                return Redirect::to(URL::previous());
            }else
            {//show error page if user has rated
                return Redirect::to('error');
            }

        }else
        {
            return Redirect::to('error');
        }
    }

    /**
    * Add more stock
    */
    public function add_stock(Request $request)
    {
        $item = new Item();

        //get data from post
        $input = array(
            'quantity' => $request->input('quantity'),
            'item_id' => $request->input('item_id')
        );
        //set rules
        $rules = array(
            'quantity' => 'required|integer|max:9999|min:1',
        );
        //make validator
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) 
        {
            // send back to upload page with errors
            return Redirect::to(URL::previous())->withInput()->withErrors($validator);
        }else 
        {//validator has no errors
            //get item
            $item_info = $item::where('items.id', '=', $input['item_id'])->first();

            //check if anything has changed
            //if yes, change the details on the database
            if($input['quantity'] != $item_info->item_quantity){
                $item_info->item_quantity = $input['quantity'];   
            }

            //save details
            $item_info->save();
            // sending success message if validation is success
            Session::flash('success', 'Stock added successfully'); 
            return Redirect::to(URL::previous());
        }//end of validator check
    }

    /**
    * Change details of an item.
    */
    public function change_item(Request $request)
    {
        $item = new Item();
        //get input from form
        $change_type = $request->input('change_type');

        //if image needs changing
        if($change_type == "image"){
            //get image data from post
            $input = array(
                'image' => Input::file('image'),
                'item_id' => $request->input('item_id')
            );
            //set rules
            $rules = array(
                'image' => 'mimes:jpeg,bmp,png|max:20000',
            );
            //make validator
            $validator = Validator::make($input, $rules);
            //set item_image to 0 as default, meaning the item has no image until validation succeeds
            $item_image = "0";

            //check validation
            if ($validator->fails()) 
            {
                // send back to upload page with errors
                return Redirect::to(URL::previous())->withInput()->withErrors($validator);
            }else 
            {//validator has no errors

                //if image was uploaded
                if (Input::hasFile('image'))
                {
                    //check if image is valid
                    if (Input::file('image')->isValid()) 
                    {
                        $image_destination = "uploads";
                        $image_extension = "png";
                        $image_new_name = $input['item_id'].".".$image_extension;
                        $file = Input::file('image');
                        $file->move($image_destination, $image_new_name);

                        //image has been uploaded
                        $item_image = "1";
                    }else 
                    {
                        // sending back with error message.
                        Session::flash('error', 'uploaded file is not valid');
                        return Redirect::to(URL::previous());
                    }
                }
                //get item
                $item_info = $item::where('items.id', '=', $input['item_id'])->first();

                if($item_image != $item_info->item_image){ 
                    $item_info->item_image = $item_image;          
                }
                $item_info->save();
                // sending success message if validation is success
                Session::flash('success', 'Updated image successfully'); 
                return Redirect::to(URL::previous());
            }//end of validator check

        //else details need changing
        }elseif($change_type == "details"){
            //get name and price data from post
            $input = array(
                'item_name' => $request->input('item_name'),
                'price' => $request->input('price'),
                'item_id' => $request->input('item_id')
            );
            //set rules
            $rules = array(
                'item_name' => 'required|string|max:255|min:2',
                'price'     => 'required|numeric|max:9999.99|min:0.1',
            );
            //make validator
            $validator = Validator::make($input, $rules);
            
           //check validation
            if ($validator->fails()) 
            {
                // send back to upload page with errors
                return Redirect::to(URL::previous())->withInput()->withErrors($validator);
            }else 
            {//validator has no errors
                //get item
                $item_info = $item::where('items.id', '=', $input['item_id'])->first();

                //check if anything has changed
                //if yes, change the details on the database
                if($input['item_name'] != $item_info->item_name){
                    $item_info->item_name = $input['item_name'];   
                }

                if($input['price'] != $item_info->price){ 
                    $item_info->price = $input['price'];          
                }
                //save details
                $item_info->save();
                // sending success message if validation is success
                Session::flash('success', 'Details updated successfully'); 
                return Redirect::to(URL::previous());
            }//end of validator check
        }
    }

    /**
    * Make a new item
    */
    public function new_item(Request $request)
    {
        $item = new Item();
        //get new item id
        $new_item_id = DB::table('items')->orderBy('id', 'desc')->first()->id + 1;

        //get data from post
        $input = array(
            'item_name' => $request->input('item_name'),
            'price' => $request->input('price'),
            'image' => Input::file('image')
        );

        //set rules
        $rules = array(
            'item_name' => 'required|string|max:255|min:2',
            'price'     => 'required|numeric|max:9999.99|min:0.1',
            'image' => 'mimes:jpeg,bmp,png|max:20000',
        );

        //make validator
        $validator = Validator::make($input, $rules);

        //set item_image to 0 as default, meaning the item has no image until validation succeeds
        $item_image = "0";

        //check validation
        if ($validator->fails()) 
        {
            // send back to upload page with errors
            return Redirect::to('admindash')->withInput()->withErrors($validator);
        }else 
        {//validator has no errors

            //if image was uploaded
            if (Input::hasFile('image'))
            {
                //check if image is valid
                if (Input::file('image')->isValid()) 
                {
                    $image_destination = "uploads";
                    $image_extension = "png";
                    $image_new_name = $new_item_id.".".$image_extension;
                    $file = Input::file('image');
                    $file->move($image_destination, $image_new_name);

                    //image has been uploaded
                    $item_image = "1";
                }else
                {
                    // sending back with error message.
                    Session::flash('error', 'uploaded file is not valid');
                    return Redirect::to('admindash');
                }
            }

            //insert data to database
            DB::table('items')->insert([
                ['id' => $new_item_id, 'item_name' => $input['item_name'], 'item_image' => $item_image, 'rating' => "0", 'price' => $input['price']]
            ]);
            // sending success message if validation is success
            Session::flash('success', 'Upload successfully'); 
            return Redirect::to('admindash');

        }//end of validator check
    }

    /**
    * Delete an item from the shop
    */
    public function item_delete($item_id)
    {
        $item = new Item();
        //if user is admin
        if(Auth::user()->admin == "1")
        {
            //delete that item
            DB::table('items')->where('id', '=', $item_id)->delete();
        }
        return Redirect::to('admindash');
    }
}
