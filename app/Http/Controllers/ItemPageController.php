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
    public function item_page()
    {
        return "You can see item details here";
        // return view('home');
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
        echo "<p>You've created a new item</p>";

        //if image is there
        if (Input::hasFile('image'))
        {
            //get image
            $file = array('image' => Input::file('image'));

            //set rules
            $rules = array('image' => 'mimes:jpeg,bmp,png|max:20000',);

            //make validator
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
            // send back to upload page with errors
            return Redirect::to('admindash')->withInput()->withErrors($validator);
            }
            else {
                if (Input::file('image')->isValid()) {
                    $image_destination = "uploads";
                    $image_extension = Input::file('image')->getClientOriginalExtension();
                    $image_extension = "png";
                    $image_new_name = $new_item_id.".".$image_extension;
                    $file = Input::file('image');
                    $file->move($image_destination, $image_new_name);
                    echo '<img src="/uploads/'. $image_new_name . '"/>';

                    echo "<p>image uploaded</p>";
                    // sending back with message
                    Session::flash('success', 'Upload successfully'); 
                    return Redirect::to('admindash');
                }
                else {
                    // sending back with error message.
                    Session::flash('error', 'uploaded file is not valid');
                    return Redirect::to('admindash');
                }
            }//end of validator check
        }

        // echo "<p>".$request->input('image')."</p>";
        // echo "<p>".$request->input('item_name')."</p>";
        // echo "<p>".$request->input('price')."</p>";
    }
}
