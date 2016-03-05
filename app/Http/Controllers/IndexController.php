<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item as Item;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
    public function __construct()
    {
        $this->middleware('auth');
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

    public function indexFilter($filter)
    {
    	$item = new Item();
    	if(($filter == 'price') OR ($filter == 'name') OR ($filter == 'review')){
    		$data = $item->showAllItems($filter);
    	}else{
    		return $this->index();
    	}
        return view('welcome')->withdata($data);
    }
}
