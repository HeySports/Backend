<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class matchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['5', '7', '11'];
        $arr_lose = ['5/5', '7/3', '6/4','0'];
        $_name=['Phong 1','Phong 2','Phong 3','Phong 4','Phong 5','Phong 6','Phong 7','Phong 8','Phong 9','Phong 10'];
        for ($i = 0; $i < 10; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            DB::table('matches')->insert([
                'id_field_play' => rand(1, 3),
                'id_user'=>rand(1,10),
                'name_room' => $_name[$i],
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'lose_pay' => $arr_lose[$r_lose],
                'password' => hash::make('123456'),
                'time_start_play' => date('Y-m-d H:i:s'),
                'time_end_play' =>  date('Y-m-d H:i:s'),
                'description' => 'San bon tôt có thể chơi lâu dài, chủ thì tích cực',
                'type' =>rand(0, 1),
            ]);
        }
    }
}
