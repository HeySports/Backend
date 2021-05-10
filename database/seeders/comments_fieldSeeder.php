<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class comments_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++){
            DB::table('comments_field')->insert([
                'id_user' => rand(1, 70),
                'id_field' => rand(1, 6),
                'description' =>  Str::random(50),
            ]);
        }
    }
}
