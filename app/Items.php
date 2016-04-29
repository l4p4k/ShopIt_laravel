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

    /*
    * Stock stats - 3 lowest rated products
    */
    public function lowest_rated(){
        $query = DB::table('items')
            ->select('*')
            ->orderBy('rating','ASC')
            ->take(3)
            ->get();

        return $query;
    }

    /*
    * Stock stats - 3 lowest stock
    */
    public function lowest_stock(){
        $query = DB::table('items')
            ->select('*')
            ->orderBy('item_quantity','ASC')
            ->take(3)
            ->get();

        return $query;
    }

    /*
    * Stock stats - 10 most bulk bought
    */
    public function most_bulk(){
        $query = DB::table('item_bought')
            ->join('items', 'item_bought.item_id', '=', 'items.id')
            ->select('item_bought.id AS bought_id','item_bought.buy_quantity AS quantity','items.*')
            ->orderBy('quantity','DESC')
            ->take(10)
            ->get();

        return $query;
    }
}
