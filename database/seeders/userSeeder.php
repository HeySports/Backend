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
        $_listName=['Thanh Doan','Nguyen Hung','Yen Nhi', 'Ngoc Tram','Nguyen Van A', 'Nguyen Van B','Nguyen Van C', 'Nguyen Van D','Nguyen Van E', 'Nguyen Van F'];
        $_email=['thanhdoanDev@gmail.com','hung@gmail.com','Nhi@gmail.com','tram@gmail.com','a@gmail.com','b@gmail.com','c@gmail.com','d@gmail.com','e@gmail.com','f@gmail.com'];
        $_phone=['0946613608','0946613610','0946613600','0946613607','0946613606','0946613605','0946613604','0946613603','0946613602','0946613601'];
        for ($i=0; $i<10; $i++){
            DB::table('users')->insert([
                'id_roles' => rand(1, 3),
                'full_name' =>  $_listName[$i],
                'email' => $_email[$i],
                'password' => Hash::make('123456'),
                'phone_numbers' => $_phone[$i],
                'address' => 'Son Tra, Da Nang',
                'avatar' => '[]',
                'age' => rand(10,60),
                'matches_number' => rand(0,20),
                'skill_rating' => rand(0,5),
                'attitude_rating' => rand(0,5),
                'position_play' => Str::random(10),
                'description' =>  Str::random(50),
            ]);
        }
       
    }
}
