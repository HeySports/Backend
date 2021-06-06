<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
        $address = ['101b Lê Hữu Trác - Sơn Trà - Đà Nẵng', '99 Tô Hiến Thành - Sơn Trà - Đà Nẵng'];
        $_name=['210b21','210b2f','20sb21','210b32','320b21','110b21','1s0d21','10ds21','10ds01','10ds71'];
        for ($i = 0; $i < 50; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            
            $min_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMonth()->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('matches')->insert([
                'id_user'=>rand(1,60),
                'name_room' => rand(100000, 199999),
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'lose_pay' => $arr_lose[$r_lose],
                'address' => $address[rand(0,1)],
                'password' => hash::make('123456'),
                'time_start_play' =>$time_start,
                'time_end_play' =>  Carbon::parse($time_start)->addHour(),
                'description' => 'San bon tôt có thể chơi lâu dài, chủ thì tích cực',
                'price'=> rand(200000,500000),
                'type' =>rand(0, 1),
                'created_at' => $time_start
            ]);
        }
        for ($i = 50; $i < 100; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            $min_epoch = strtotime('2021-05-29 14:08:29');
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('matches')->insert([
                'id_user'=>rand(20,90),
                'name_room' => Str::random(6).rand(10, 99),
                'field_name' => "Sân trường cao đẳng Nghề",
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'lose_pay' => $arr_lose[$r_lose],
                'address' => $address[rand(0,1)],
                'password' => hash::make('123456'),
                'time_start_play' =>$time_start,
                'time_end_play' =>  Carbon::parse($time_start)->addHour(),
                'description' => 'San bon tôt có thể chơi lâu dài, chủ thì tích cực',
                'price'=> rand(200000,500000),
                'type' =>rand(0, 1),
                'created_at' => $time_start
            ]);
        }
    }
}
