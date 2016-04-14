<?php

namespace App;
use DB;
use Session;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = "items";

    public function show_all_items($filter, $order){
    	$data = $query = DB::table('items')
    		->select('*')
            //if price is not review
            ->orderBy($filter, $order)
    		->paginate(10);
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
            ->orderBy('review', 'DESC')
            ->where($column, 'like','%'.$criteria.'%')
            ->get();

        $num_on_page = 5;
        $search_result = count($query);
        if($search_result > $num_on_page){
            $query_page = DB::table('items')
            ->select('*')
            ->orderBy('review', 'DESC')
            ->where($column, 'like','%'.$criteria.'%')
            ->paginate($num_on_page);

            //second param is if results should be paged or not
            return [$query_page,'1', $search_result];
        }elseif($search_result < $num_on_page+1){
            return [$query,'0', $search_result];
        }

    }
}
