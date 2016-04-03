<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "item";

    public function showAllItems($filter){
    	$data = $query = DB::table('item')
    		->select('item.*')
    		->orderBy('item.'.$filter)
    		->get();
    	return $data;
    }
}
