<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class item_bought extends Model
{
    protected $table = "item_bought";

	//check if user has bought item ever
    public function has_bought($user_id, $item_id)
    {
        $data = $query = DB::table('item_bought')
            ->select('*')
            ->where('user_id','=',$user_id)
            ->where('item_id','=',$item_id)
            ->first();

            if($data == null){
                return false;
            }else
            {
                return true;
            }

    	// $data = $query = DB::table('rating')
     //        ->join('item_bought', 'rating.item_id', '=', 'item_bought.user_id')
    	// 	->select('item_bought.id AS item_bought_id', 'item_bought.item_id', 'item_bought.buy_quantity', 'rating.review')
    	// 	->where('user_id','=',$user_id)
    	// 	->where('item_id','=',$item_id)
    	// 	->first();
    	// return $data;
    }

    public function can_rate($user_id, $item_id)
    {
        $data = $query = DB::table('rating')
         ->join('item_bought', 'rating.item_id', '=', 'item_bought.item_id')
         ->select('item_bought.id AS item_id', 'item_bought.user_id', 'item_bought.buy_quantity', 'rating.rating')
         ->where('rating.user_id','=',$user_id)
         ->where('rating.item_id','=',$item_id)
         ->first();
        return $data;
    }

    public function user_bought($user_id)
    {
        $data = $query = DB::table('item_bought')
            ->join('items', 'item_bought.item_id', '=', 'items.id')
            ->select('item_bought.id AS bought_id','item_bought.buy_quantity AS quantity','items.*')
            ->orderBy('id', 'ASC')
            ->where('user_id','=',$user_id)
            ->get();
        return $data;
    }
}
