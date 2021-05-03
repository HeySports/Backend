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
        $_name=['N1','N2','N3','N4','N5', 'N6'];
        for($i = 0; $i < 6; $i++){
            $r = rand(0,2);
            DB::table('child_fields')->insert([
                'id_field' => rand(1, 3),
                'name_field' =>$_name[$i],
                'type' => $arr[$r],
                'status' => rand(0, 1),
                'description' =>  Str::random(50),
            ]);
        }
    }
}
