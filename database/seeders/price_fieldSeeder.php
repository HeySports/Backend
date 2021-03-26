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
        $arr = ['5', '7', '11'];
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++){
            $r = rand(0, 2);
            DB::table('price_fields')->insert([
                'id_field' => rand(1, 3),
                'type_field' => $arr[$r],
                'time_start' => $faker->dateTime($max = 'now', $timezone = null),
                'time_end' => $faker->dateTime($max = 'now', $timezone = null),
                'price'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1000000),
            ]);
        }
    }
}
