<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++){
            DB::table('orders')->insert([
                'id_match' => rand(1, 5),
                'id_child_field' => rand(1, 6),
                'id_user' => rand(1, 6),
                'status' => rand(0,1),
                'time_start' =>  date('Y-m-d H:i:s'),
                'time_end' => date('Y-m-d H:i:s'),
                'description' => 'Description',
            ]);
        }
    }
}
