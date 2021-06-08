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
        $_name =['PN21 Club', 'Cộng Hòa Team', 'Gà Chiến Mỹ Khê', 'CLB Sơn Trà', 'CLB Hải Châu'];
        for ($i = 0; $i < 20; $i++){
            DB::table('detail_matches')->insert([
                'id_user' => rand(1, 10),
                'id_match' => rand(1, 20),
                'status_team' => 0,
                'numbers_user_added' => rand(1,5),
                'team_name' => $_name[rand(0, 4)],
            ]);
        }
        for ($i = 0; $i < 20; $i++){
            DB::table('detail_matches')->insert([
                'id_user' => rand(1, 10),
                'id_match' => rand(1, 20),
                'status_team' => 1,
                'numbers_user_added' => rand(1,5),
                'team_name' => $_name[rand(0, 4)],
            ]);
        }
    }
}
