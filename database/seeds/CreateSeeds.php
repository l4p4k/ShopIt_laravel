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
        DB::table('items')->delete();
        DB::table('users')->delete();

        $faker = Faker::create();
        foreach (range(1,30) as $index) {
        	DB::table('items')->insert([
        		'item_name' => $faker->word." ".$faker->word,
                'item_image' => "0",
        		'rating' => "2",
                'item_quantity' => $faker->numberBetween(1,40),
        		'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999)
        	]);
        }

        DB::table('users')->insert([
            'fname'        => "Ebrahim",
            'sname'        => "Ravat",
            'admin'        => "1",
            'email'        => "eby_146@hotmail.co.uk",
            'phone'        => "",
            'house_no'     => "24",
            'postcode'     => "WF17 7ND",
            'password'     => bcrypt('poop123')
        ]);

        foreach (range(1,10) as $index) {
            $name = $faker->firstName();
            $sname = $faker->lastName();
            DB::table('users')->insert([
                'fname'        => $name,
                'sname'        => $sname,
                'admin'        => "0",
                'email'        => $name."@".$faker->domainName,
                'phone'        => "07".$faker->numberBetween(100000000, 999999999),
                'house_no'     => $faker->numberBetween(1,200),
                'postcode'     => $faker->postcode(),
                'password'     => bcrypt('poop123')
            ]);
        }
    }
}
