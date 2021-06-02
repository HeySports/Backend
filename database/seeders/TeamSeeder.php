<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_arr =['PN21 Club', 'Cộng Hòa Team', 'Gà Chiến Mỹ Khê', 'CLB Sơn Trà', 'CLB Hải Châu'];
        $_address=['101B Lê Hữu Trác, Sơn Trà', 'Ông ích Kiêm, Hải Châu', 'Mỹ Khê 3, Sơn Trà', 'Tô Hiến Thành,Sơn Trà', 'Hải Châu','Sơn Trà'];

        for ($i = 0; $i < 50; $i++){
            DB::table('teams')->insert([
                'name' => $_arr[rand(0,4)],
                'address' =>$_address[rand(0,4)],
                'description' => Str::random(50),
                'rating' => rand(1,5),
                'rating_number' => rand(1,10),
            ]);
        }
    }
}
