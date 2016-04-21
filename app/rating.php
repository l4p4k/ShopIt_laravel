<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    protected $table = "items";

    //get number of user ratings
    public function get_item_rating_count($item_id)
    {
        $query = DB::table('rating')
            ->select('rating.*')
            ->where('rating.item_id', '=', $item_id)
            ->count();

        return $query;
    }

    //average out ratings from users
    public function avg_rating($item_id)
    {
        $query = DB::table('rating')
            ->select('rating.*')
            ->where('rating.item_id', '=', $item_id)
            ->avg('rating');

        return number_format((float)$query, 2, '.', '');
    }

    //update item.rating column
    public function update_item_rating($item_id, $item_rating)
    {
        //get item
        $update_rating = DB::table('items')
        	->where('id', '=', $item_id)
        	->update(['rating' => $item_rating]);
        return;
    }
}
