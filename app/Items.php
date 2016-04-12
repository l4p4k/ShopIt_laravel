<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = "items";

    public function showAllItems($filter){
    	$data = $query = DB::table('items')
    		->select('*')
    		->orderBy($filter)
    		->get();
    	return $data;
    }

    public function search($column, $criteria){
        $query = DB::table('items')
            ->select('*')
            ->orderBy('item_id', 'DESC')
            ->where($column, 'like','%'.$criteria.'%')
            ->get();

        return $query;
    }
}
