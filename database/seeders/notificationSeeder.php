<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class notificationSeeder extends Seeder
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
            DB::table('notifications')->insert([
                'type' => $faker->randomDigit,
                'id_match' => rand(1, 3),
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);
        }
    }
}
