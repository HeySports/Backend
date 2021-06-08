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
        $price = [200000, 300000, 400000];
        $arr_lose = ['5/5', '7/3', '6/4','0'];
        $address=['Hoà Minh, Liên Chiểu, Đà Nẵng','45 Dũng Sĩ Thanh Khê, Thanh Khê, ĐN', '98 Tiểu La, Hoà Thuận Đông, Hải Châu, ĐN','22 Đ 2/9, Bình Hiên, Hải Châu, ĐN',
        '403 Trưng Nữ Vương, Hoà Thuận Nam, Hải Châu, ĐN',' 86 Duy Tân, Hoà Thuận Nam, Hải Châu, ĐN', '498 Nguyễn Hữu Thọ, Khuê Trung, Cẩm Lệ, ĐN', '07 Duy Tân, Hoà Cường Bắc, Hải Châu, ĐN','409 Trưng Nữ Vương, Hoà Thuận Nam, Hải Châu, ĐN',
        '146 Duy Tân, Hoà Thuận Nam, Hải Châu, ĐN','Thanh Khê Đông, Thanh Khê, ĐN','Nguyễn Văn Tạo, Hoà An, Cẩm Lệ, ĐN','243 Trường Chinh, An Khê, Thanh Khê, ĐN','Bế Văn Đàn, Chính Gián, Thanh Khê, ĐN', 'SNguyễn Tất Thành, khu đô thị Đa Phước, Hải Châu, ĐN',
       '08 Nguyễn Phước Lan, Hoà Xuân, Cẩm Lê, ĐN','38 Ông Ích Đường, Khuê Trung, Cẩm Lệ, ĐN','An Trung 3, An Hải Tây, Sơn Trà, ĐN','44 Dũng Sĩ Thanh Khê, Thanh Khê Đông, Thanh Khê, ĐN'];        $_name=['210b21','210b2f','20sb21','210b32','320b21','110b21','1s0d21','10ds21','10ds01','10ds71'];
        for ($i = 0; $i < 10; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            
            $min_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMonth()->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('matches')->insert([
                'id_user'=>rand(1,10),
                'name_room' => rand(100000, 199999),
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'field_name' => "Sân trường cao đẳng Nghề",
                'lose_pay' => $arr_lose[$r_lose],
                'address' => $address[rand(0,10)],
                'password' => hash::make('123456'),
                'time_start_play' =>$time_start,
                'time_end_play' =>  Carbon::parse($time_start)->addHour(),
                'description' => 'Có thể chơi lâu dài, tích cực',
                'price'=> $price[$r],
                'type' =>0,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')
            ]);
        }
        for ($i = 0; $i < 10; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            
            $min_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMonth()->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('matches')->insert([
                'id_user'=>rand(1,10),
                'name_room' => rand(100000, 199999),
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'field_name' => "Sân trường cao đẳng Nghề",
                'lose_pay' => $arr_lose[$r_lose],
                'address' => $address[rand(0,1)],
                'password' => hash::make('123456'),
                'time_start_play' =>$time_start,
                'time_end_play' =>  Carbon::parse($time_start)->addHour(),
                'description' => 'Có thể chơi lâu dài, tích cực',
                'price'=> $price[$r],
                'type' =>1,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')
            ]);
        }
        for ($i = 10; $i < 20; $i++){
            $r = rand(0, 2);
            $r_lose = rand(0, 3);
            $min_epoch = strtotime('2021-05-29 14:08:29');
            $max_epoch = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $time_start = date('Y-m-d H:i:s', $rand_epoch);
            DB::table('matches')->insert([
                'id_user'=>rand(1,10),
                'name_room' => Str::random(4).rand(10, 99),
                'field_name' => "Sân trường cao đẳng Nghề",
                'lock' => rand(0, 1),
                'type_field' => $arr[$r],
                'lose_pay' => $arr_lose[$r_lose],
                'address' => $address[rand(0,1)],
                'password' => hash::make('123456'),
                'time_start_play' =>$time_start,
                'time_end_play' =>  Carbon::parse($time_start)->addHour(),
                'description' => 'Tìm các bạn chung kĩ năng',
                'price'=> $price[$r],
                'type' =>rand(0, 1),
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')
            ]);
        }
    }
}
