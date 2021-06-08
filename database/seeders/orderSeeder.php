<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Tạo các order 
        for ($i = 0; $i < 15; $i++){
            $min_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMonth()->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('orders')->insert([
                'id_match' => rand(1,10),
                'id_child_field' => rand(1,20),
                'id_user' => rand(1, 10),
                'status' => rand(0,1),
                'method_pay' => rand(0,2),
                'time_start' => $time_start,
                'time_end' => Carbon::parse($time_start)->addHour(),
                'description' => 'Description',
            ]);
        }
        
        for ($i = 15; $i < 30; $i++){
            $min_epoch = strtotime('2021-05-29 14:08:29');
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('orders')->insert([
                'id_match' => rand(10, 20),
                'id_child_field' => rand(1,10),
                'id_user' => rand(1, 10),
                'status' => rand(0,1),
                'method_pay' => rand(0,2),
                'time_start' => $time_start,
                'time_end' => Carbon::parse($time_start)->addHour(),
                'description' => 'Description',
                'created_at' => $time_start
            ]);
        }
    }
}
