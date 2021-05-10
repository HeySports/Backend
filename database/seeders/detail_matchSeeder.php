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
        for ($i = 0; $i < 50; $i++){
            DB::table('detail_matches')->insert([
                'id_user' => rand(1, 50),
                'id_match' => rand(1, 99),
                'status_team' => 0,
                'numbers_user_added' => rand(0,10),
                'team_name' => $_name[rand(0, 4)],
            ]);
        }
        for ($i = 50; $i < 100; $i++){
            DB::table('detail_matches')->insert([
                'id_user' => rand(10, 60),
                'id_match' => rand(40, 90),
                'status_team' => rand(0,1),
                'numbers_user_added' => rand(0,10),
                'team_name' => $_name[rand(0, 4)],
            ]);
        }
    }
}
