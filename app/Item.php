<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "item";

    public function showAllItems($filter){
    	$query = DB::table('item')
    		->select('item.*')
    		->orderBy('item.'.$filter)
    		->get();

    	foreach ($query as $key => $value) {
    		$data[$key]['name'] = $value->name;
    		$data[$key]['price'] = $value->price;
    		$data[$key]['review'] = $value->review;
    	}
    	return $data;
    }

    public function showAllItemsSortPrice(){
    	$query = DB::table('item')
    		->select('item.*')
    		->orderBy('item.price')
    		->get();

    	foreach ($query as $key => $value) {
    		$data[$key]['name'] = $value->name;
    		$data[$key]['price'] = $value->price;
    		$data[$key]['review'] = $value->review;
    	}
    	return $data;
    }

}
