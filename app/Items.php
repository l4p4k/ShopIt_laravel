<?php

namespace App;
use DB;
use Session;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = "items";

    public function show_all_items($filter){
    	$data = $query = DB::table('items')
    		->select('*')
    		->orderBy($filter)
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
            ->orderBy('item_id', 'DESC')
            ->where($column, 'like','%'.$criteria.'%')
            ->get();

        $num_on_page = 5;
        if(count($query) > $num_on_page){
            $query_page = DB::table('items')
            ->select('*')
            ->orderBy('item_id', 'DESC')
            ->where($column, 'like','%'.$criteria.'%')
            ->paginate($num_on_page);

            //second param is if results should be paged or not
            return [$query_page,'1'];
        }elseif(count($query) < $num_on_page+1){
            return [$query,'0'];
        }

    }
}
