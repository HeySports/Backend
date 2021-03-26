<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class matchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['5', '7', '11'];
        $arr_lose = ['5/5', '7/3', '6/4','0'];
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            DB::table('matches')->insert([
                'id_field_play' => rand(1, 3),
                'name_room' => Str::random(10),
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'lose_pay' => $arr_lose[$r_lose],
                'password' => $faker->password,
                'time_start_play' => $faker->dateTime($max = 'now', $timezone = null),
                'time_end_play' => $faker->dateTime($max = 'now', $timezone = null),
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
                'type' =>rand(0, 1),
                'price'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1000000),
            ]);
        }
    }
}
