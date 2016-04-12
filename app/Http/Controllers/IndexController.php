<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Http\Controllers\Controller;

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
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
    {
    	$item = new Item();
    	$data = $item->showAllItems('item_name');
        return view('welcome')->withdata($data);
    }

    public function indexFilter(Request $request)
    {
    	$item = new Item();
        $filter = $request->input('filter');
        if($filter != null)
        {
		    $data = $item->showAllItems($filter);
            return view('welcome')->withdata($data);
        }else{
            return $this->index();
        }
    }

    //WIP-- searches for items with that keyword in name --WIP
    public function search(Request $request)
    {   $item = new Item();
        // Get data
        $input_data = array(
            'search'     => $request->input('search')
        );
        // Build the validation rules.
        $rules = array(
            'search'     => 'string|min:3'
        );

        // Create a new validator instance.
        $validator = Validator::make($input_data, $rules);

        if($input_data['search'] == ""){
            $error = array('search' => "The search key must not be empty");
            return Redirect::to(URL::previous())->withErrors($error)->withInput();
        }

         if (($validator->fails())) {
            return Redirect::to(URL::previous())->withErrors($validator)->withInput();
        }
        // If the data passes validation
        if ($validator->passes()) {
            $data[0] = $item->search('item_name', $input_data['search']);
            // var_dump($data);
            return view('results')->withdata($data);
        }
    }
}
