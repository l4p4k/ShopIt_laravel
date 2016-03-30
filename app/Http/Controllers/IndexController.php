<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Item as Item;

class IndexController extends Controller
{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'indexFilter']]);
    }

	/**
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
    {
    	$item = new Item();
    	$data = $item->showAllItems('name');
        return view('welcome')->withdata($data);
    }

    public function indexFilter(Request $request)
    {
    	$item = new Item();
		$data = $item->showAllItems($request->input('filter'));
        return view('welcome')->withdata($data);
    }
}
