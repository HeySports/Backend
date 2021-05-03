<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class detail_matchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_name=['Phong 1','Phong 2','Phong 3','Phong 4','Phong 5','Phong 6','Phong 7','Phong 8','Phong 9','Phong 10'];
        for ($i = 0; $i < 10; $i++){
            DB::table('detail_matches')->insert([
                'id_user' => rand(1, 3),
                'id_match' => rand(1, 3),
                'status_team' => rand(0,1 ),
                'numbers_user_added' => rand(0,10),
                'team_name' => $_name[$i],
            ]);
        }
    }
}