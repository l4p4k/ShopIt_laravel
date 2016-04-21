<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    protected $table = "items";

    public function get_item_rating($item_id)
    {
        $avg_query = DB::table('rating')
            ->select('rating.*')
            ->where('rating.item_id', '=', $item_id)
            ->avg('rating');

        $sum_query = DB::table('rating')
            ->select('rating.*')
            ->where('rating.item_id', '=', $item_id)
            ->count();

           $query = [number_format((float)$avg_query, 2, '.', ''),$sum_query];
        return $query;
    }

    public function update_item_rating($item_id, $item_rating)
    {
        //get item
        $update_rating = DB::table('items')
        	->where('id', '=', $item_id)
        	->update(['rating' => $item_rating]);
        return;
    }
}
