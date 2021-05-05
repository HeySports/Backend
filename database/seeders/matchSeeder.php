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
        $_name=['210b21','210b2f','20sb21','210b32','320b21','110b21','1s0d21','10ds21','10ds01','10ds71'];
        for ($i = 0; $i < 10; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            DB::table('matches')->insert([
                'id_field_play' => rand(1, 6),
                'id_child_field'=>rand(1,6),
                'id_user'=>rand(1,10),
                'name_room' => $_name[$i],
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'lose_pay' => $arr_lose[$r_lose],
                'address' => '101b Le Huu Trac',
                'password' => hash::make('123456'),
                'time_start_play' => date('Y-m-d H:i:s'),
                'time_end_play' =>  date('Y-m-d H:i:s'),
                'description' => 'San bon tôt có thể chơi lâu dài, chủ thì tích cực',
                'price'=> rand(200000,500000),
                'type' =>rand(0, 1),
            ]);
        }
    }
}
