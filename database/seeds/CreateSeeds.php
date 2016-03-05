<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CreateSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,30) as $index) {
        	DB::table('item')->insert([
        		'name' => $faker->word." ".$faker->word,
        		'review' => $faker->numberBetween(1,10),
        		'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999)
        	]);
        }
    }
}
