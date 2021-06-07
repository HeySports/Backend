<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class notificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++){
            DB::table('notifications')->insert([
                'type' => 1,
                'id_match' => rand(1, 50),
                'description' => 'Hùng HLV đã tạo 1 trận đấu mới',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addHours($i+2)
            ]);
        }
        for ($i = 50; $i < 100; $i++){
            DB::table('notifications')->insert([
                'type' => 0,
                'id_match' => rand(1, 50),
                'description' => 'Sân bóng Duy Tân giảm 50% cho tất cả sân 5vs5',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addHours($i+2)
            ]);
        }
    }
}
