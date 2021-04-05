<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class child_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['5','7','11'];
        $faker = Faker::create();
        for($i = 0; $i < 10; $i++){
            $r = rand(0,2);
            DB::table('child_fields')->insert([
                'id_field' => rand(1, 3),
                'name_field' => $faker->name,
                'type' => $arr[$r],
                'status' => rand(true, false),
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);
        }
    }
}
