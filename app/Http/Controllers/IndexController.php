<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Items as Item;

use Session;
use Validator;
use URL;
use Auth;

class IndexController extends Controller
{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'indexFilter', 'search']]);
    }

	/**
	* Show the index page.
	*
	*/
	public function index()
    {
    	$item = new Item();
    	$data = $item->show_all_items('id', 'asc');
        return view('welcome')->withdata($data);
    }

    /**
    * Filter items on the page
    */
    public function indexFilter(Request $request)
    {
    	$item = new Item();
        $filter = $request->input('filter');
        $order = $request->input('order');
        if($filter != null && $order != null)
        {
		    $data = $item->show_all_items($filter, $order);
            return view('welcome')->withdata($data);
        }else{
            return $this->index();
        }
    }

    /**
    * search for an item using keyword
    */
    public function search(Request $request)
    {   $item = new Item();
        // Get data
        $input_data = array(
            'search'     => $request->input('search')
        );
        // Build the validation rules.
        $rules = array(
            'search'     => 'string|min:1'
        );

        // Create a new validator instance.
        $validator = Validator::make($input_data, $rules);

        if($input_data['search'] == ""){
            $error = array('search' => "The search key must not be empty");
            return Redirect::to('profile')->withErrors($error)->withInput();
        }

         if (($validator->fails())) {
            return Redirect::to('profile')->withErrors($validator)->withInput();
        }
        // If the data passes validation
        if ($validator->passes()) 
        {
            //search for item with keyword
            $data = $item->search('item_name', $input_data['search']);
            //get number of results found
            $result_count = count($data[0]);
            // show results page
            return view('results')
            ->with('data', $data[0])
            ->with('result_count', $data[1]);
        }
    }
}
