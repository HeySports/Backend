<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = ['101b Lê Hữu Trác - Sơn Trà - Đà Nẵng', '99 Tô Hiến Thành - Sơn Trà - Đà Nẵng'];
        $long=[16068939,16073887, 16046397, 16035003, 16048606, 16051262,16031422, 16049999
        ,16046966, 16053344, 160071391, 16055177,16050691
        ,16066359,16077608   ,16024408
        ,16019858 ,16057495, 16071960 ];
        $lat=[108170022 ,108177318 ,108214454 ,108226816 ,108210098 ,108211693 ,108207945 ,108215703 ,108211627 ,
        108206614 ,108183363 ,108174595 ,108183668 ,108194122 ,108204987 ,108224250 ,108204066 ,108234181 ,108180323];
        $_listName=['Thanh Doan','Nguyen Hung','Yen Nhi', 'Ngoc Tram','Nguyen Van A', 'Nguyen Van B','Nguyen Van C', 'Nguyen Van D','Nguyen Van E', 'Nguyen Van F'];
        $_email=['thanhdoanDev@gmail.com','hung@gmail.com','Nhi@gmail.com','tram@gmail.com','a@gmail.com','b@gmail.com','c@gmail.com','d@gmail.com','e@gmail.com','f@gmail.com'];
        $_phone=['0946613655','0946613610','0946613600','0946613607','0946613606','0946613605','0946613604','0946613603','0946613602','0946613601'];
        $_position=['Tiền Đạo','Tiền Vệ Tâm','Trung Vệ','Hậu vệ cánh trái','Hậu vệ cánh phải','Tiền Vệ Công','Thủ Môn','Tiền Đạo Cắm', 'Tiền Đạo Biên','Tiền Vệ Trụ'];
        for ($i=0; $i<10; $i++){
            DB::table('users')->insert([
                'id_roles' => rand(1, 3),
                'full_name' =>  $_listName[$i],
                'email' => $_email[$i],
                'password' => Hash::make('123456'),
                'phone_numbers' => $_phone[$i],
                'address' => 'Son Tra, Da Nang',
                'avatar' => '[]',
                'longitude'=>$long[rand(0,18)],
                'latitude'=> $lat[rand(0,18)],
                'rating_number' => rand(1,10),
                'age' => rand(10,60),
                'matches_number' => rand(0,20),
                'skill_rating' => rand(0,10),
                'attitude_rating' => rand(0,5),
                'position_play' => $_position[$i],
                'description' =>  Str::random(50),
            ]);
        }
        for ($i=0; $i<90; $i++){
            DB::table('users')->insert([
                'id_roles' => rand(1, 3),
                'full_name' =>  $_listName[rand(0,9)],
                'email' =>   Str::random(10) . '@gmail.com',
                'password' => Hash::make('123456'),
                'phone_numbers' => '03'. strval(rand(10000000,19999999)),
                'address' => $address[rand(0,1)],
                'avatar' => '[]',
                'age' => rand(10,60),
                'rating_number' => rand(1,10),
                'longitude'=>$long[rand(0,18)],
                'latitude'=> $lat[rand(0,18)],
                'matches_number' => rand(0,20),
                'skill_rating' => rand(0,10),
                'attitude_rating' => rand(0,5),
                'position_play' => $_position[rand(0,9)],
                'description' =>  Str::random(50),
            ]);
        }
       
    }
}
