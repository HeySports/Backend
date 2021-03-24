<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 

class price_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++){
            DB::table('price_fields')->insert([
                'id_child_field' => rand(1, 3), 
                'time_start' => $faker->dateTime($max = 'now', $timezone = null),
                'time_end' => $faker->dateTime($max = 'now', $timezone = null),
                'price'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1000000),
                'description'=> $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);
        }
    }
}
