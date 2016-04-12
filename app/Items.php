<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = "items";

    public function show_all_items($filter){
    	$data = $query = DB::table('items')
    		->select('*')
    		->orderBy($filter)
    		->get();
    	return $data;
    }

    public function show_item_with_id($id){
        $data = $query = DB::table('items')
            ->select('*')
            ->where('item_id', '=', $id)
            ->first();
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
