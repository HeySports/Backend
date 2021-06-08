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
        $address = ['76 Tô Hiến Thành - Sơn Trà - Đà Nẵng','85 Lê Hữu Trác - Sơn Trà - Đà Nẵng','101b Lê Hữu Trác - Sơn Trà - Đà Nẵng', '99 Tô Hiến Thành - Sơn Trà - Đà Nẵng'];
        $lat=['16.068939','16.073887', '16.046397', '16.035003', '16.048606', '16.051262','16.031422', '16.049999'
        ,'16.046966', '16.053344', '160.071391', '16.055177','16.050691'
        ,'16.066359','16.077608'   ,'16.024408'
        ,'16.019858' ,'16.057495', '16.071960' ];
        $long=['108.170022' ,'108.177318' ,'108.214454' ,'108.226816' ,'108.210098' ,'108.211693' ,'108.207945' ,'108.215703' ,'108.211627' ,
        '108.206614' ,'108.183363' ,'108.174595' ,'108.183668' ,'108.194122' ,'108.204987' ,'108.224250' ,'108.204066' ,'108.234181' ,'108.180323'];

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
                'address' => $address[rand(0,3)],
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
    }
}
