<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class child_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = {5, 7, 11};
        $faker = Faker::create();
        for (int i = 0; i < 10; i++){
            DB::table('child_fields')->insert([
                'id_field',
                'name_field'= $faker->name,
                'type'->,
                'status'-> rand(0, 2),
                'description'= $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);
        }
    }
}
