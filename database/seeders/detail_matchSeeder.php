<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class detail_matchSeeder extends Seeder
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
            DB::table('detail_matches')->insert([
                'id_user' => rand(1, 3),
                'id_match' => rand(1, 3),
                'status_team' => rand(true, false),
                'numbers_user_added' => $faker->randomDigit,
                'team_name' => $faker->name,
            ]);
        }
    }
}
