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
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++){
            DB::table('matches')->insert([
                'id_field_play' => rand(1, 3),
                'name_room' => $faker->name,
                'lock' => rand(0, 1),
                'password' => $faker->password,
                'time_start_play' => $faker->dateTime($max = 'now', $timezone = null),
                'time_end_play' => $faker->dateTime($max = 'now', $timezone = null),
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);
        }
    }
}
