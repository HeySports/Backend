<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 

class price_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['5', '7', '11'];
        for ($i = 1; $i < 7; $i++){
            DB::table('price_fields')->insert([
                'id_field' => $i,
                'type_field' => 5,
                'time_start' =>  date('Y-m-d H:i:s'),
                'time_end' =>  date('Y-m-d H:i:s'),
                'price'=> rand(200000,500000),
            ]);
            DB::table('price_fields')->insert([
                'id_field' => $i,
                'type_field' => 11,
                'time_start' =>  date('Y-m-d H:i:s'),
                'time_end' =>  date('Y-m-d H:i:s'),
                'price'=> rand(200000,500000),
            ]);
            DB::table('price_fields')->insert([
                'id_field' => $i,
                'type_field' => 7,
                'time_start' =>  date('Y-m-d H:i:s'),
                'time_end' =>  date('Y-m-d H:i:s'),
                'price'=> rand(200000,500000),
            ]);
        }
    }
}
