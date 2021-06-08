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
        for($i = 0; $i < 19; $i++){
            $r = rand(0,2);
            $n = rand(5,10)*2;
            for($j = 0; $j < $n; $j++){
                DB::table('child_fields')->insert([
                    'id_field' => $i+1,
                    'name_field' =>strtoupper(Str::random(1)).rand(1,9),
                    'type' => $arr[$r],
                    'status' => rand(0, 1),
                    'description' =>  'Sân mới thay cỏ nhân tạo',
                ]);
            }
            
        }
    }
}
