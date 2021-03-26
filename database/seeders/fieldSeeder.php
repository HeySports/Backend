<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 10; $i++){
            DB::table('fields')->insert([
                'id_owner' => rand(1, 3),
                'name' => $faker->name,
                'rating' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 10),
                'list_image' => '[]',
                'address' => $faker->address,
                'email_field' => $faker->email,
                'phone_numbers' => $faker->e164PhoneNumber,
                'status' => rand(true, false),
                'quantities_field' => rand(10, 20),
            ]);
        }
    }
}
