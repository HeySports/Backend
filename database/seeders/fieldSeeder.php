<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_name=['Duy Tân','Lê Quý Đôn', 'Tuyên Sơn','Hemory', 'Bách Khoa','Sân T20'];
        $_address=['101B Lê Hữu Trác, Sơn Trà', 'Ông ích Kiêm, Hải Châu', 'Mỹ Khê 3, Sơn Trà', 'Tô Hiến Thành,Sơn Trà', 'Hải Châu','Sơn Trà'];
        $_email=['a@gmail.com','b@gmail.com','c@gmail.com','d@gmail.com','e@gmail.com','f@gmail.com'];
        $_phone=['0946613606','0946613605','0946613604','0946613603','0946613602','0946613601'];

        for($i = 0; $i < 6; $i++){
            DB::table('fields')->insert([
                'id_owner' => rand(1, 3),
                'name' => $_name[$i],
                'rating' => rand(1,5),
                'rating_number'=>rand(1, 5),
                'list_image' => '[]',
                'address' => $_address[$i],
                'email_field' => $_email[$i],
                'phone_numbers' => $_phone[$i],
                'status' => 1,
                'quantities_field' => rand(10, 20),
            ]);
        }
        DB::table('fields')->insert([
            'id_owner' => 1,
            'name' => 'Đã Có Sân',
            'rating' => 0,
            'rating_number'=>0,
            'list_image' => '[]',
            'address' => 'Do Người Chơi Tự Chọn',
            'email_field' => 'Mặc định',
            'phone_numbers' => 'Mặc định',
            'status' => 0,
            'quantities_field' => 0,
        ]);
    }
}
