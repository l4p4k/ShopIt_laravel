<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = "items";

    public function show_all_items($filter, $order){
    	$data = $query = DB::table('items')
    		->select('items.*')
            //if price is not review
            ->orderBy($filter, $order)
    		->paginate(10);
    	return $data;
    }

    public function show_item_with_id($id){
        $data = $query = DB::table('items')
            ->select('*')
            ->where('id', '=', $id)
            ->first();
        return $data;
    }

    public function search($column, $criteria){
        $query = DB::table('items')
            ->select('*')
            ->orderBy('rating', 'DESC')
            ->where($column, 'like','%'.$criteria.'%')
            ->get();

        $num_on_page = 5;
        $search_result = count($query);
        $query_page = DB::table('items')
        ->select('*')
        ->orderBy('rating', 'DESC')
        ->where($column, 'like','%'.$criteria.'%')
        ->paginate($num_on_page);

        return [$query_page, $search_result];
    }

}
