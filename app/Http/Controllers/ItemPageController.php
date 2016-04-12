<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Validator;
use Auth;
use DB;
use Session;

use Illuminate\Support\Facades\Input as Input;
use App\Items as Item;

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
    public function item_page($id)
    {
        $item = new Item();
        $data = $item->show_item_with_id($id);
        return view('itemView')->withdata($data);
    }
    public function item_edit()
    {
        return "Admins edit this item here";
    }

    public function new_item(Request $request)
    {
        $item = new Item();
        //get new item id
        $new_item_id = DB::table('items')->orderBy('item_id', 'desc')->first()->item_id + 1;

        //get image
        $input = array(
            'item_name' => $request->input('item_name'),
            'price' => $request->input('price'),
            'image' => Input::file('image')
        );

        //set rules
        $rules = array(
            'item_name' => 'required|string|max:255|min:2',
            'price'     => 'required|numeric|max:9999|min:0',
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
        }
        else {//validator has no errors

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
                }
                else {
                    // sending back with error message.
                    Session::flash('error', 'uploaded file is not valid');
                    return Redirect::to('admindash');
                }
            }


            DB::table('items')->insert([
                ['item_id' => $new_item_id, 'item_name' => $input['item_name'], 'item_image' => $item_image, 'review' => "0", 'price' => $input['price']]
            ]);
            // sending success message if validation is success
            Session::flash('success', 'Upload successfully'); 
            return Redirect::to('admindash');

        }//end of validator check
    }
}
