<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i<10; $i++){
            DB::table('users')->insert([
                'id_roles' => rand(1, 3),
                'full_name' =>  $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('123456'),
                'phone_numbers' => $faker->e164PhoneNumber,
                'address' => $faker->address,
                'avatar' => '[]',
                'list_team' => '[1,2]',
                'age' => $faker->numberBetween($min = 10, $max = 70),
                'matches_number' => $faker->randomDigit,
                'skill_rating' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 10),
                'attitude_rating' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 5),
                'position_play' => Str::random(10),
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);
        }
       
    }
}
