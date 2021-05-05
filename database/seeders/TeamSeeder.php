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
        $_arr =['Team A', 'Team B', 'Team C', 'Team D', 'Team E'];
        $_address=['101B Lê Hữu Trác, Sơn Trà', 'Ông ích Kiêm, Hải Châu', 'Mỹ Khê 3, Sơn Trà', 'Tô Hiến Thành,Sơn Trà', 'Hải Châu','Sơn Trà'];

        for ($i = 0; $i < 5; $i++){
            DB::table('teams')->insert([
                'name' => $_arr[$i],
                'address' =>$_address[$i],
                'description' => Str::random(50),
            ]);
        }
    }
}
