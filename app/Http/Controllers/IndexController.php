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
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
    {
    	$item = new Item();
    	$data = $item->show_all_items('item_id', 'asc');
        return view('welcome')->withdata($data);
    }

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

    //WIP-- searches for items with that keyword in name --WIP
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
            $data = $item->search('item_name', $input_data['search']);
            $result_count = count($data);
            // var_dump($data);
            return view('results')
            ->with('data', $data[0])
            ->with('paged', $data[1])
            ->with('result_count', $data[2]);
        }
    }
}
