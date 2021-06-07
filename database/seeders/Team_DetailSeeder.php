<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class Team_DetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++){
            DB::table('team_details')->insert([
                'id_user' => $i+1,
                'id_team' =>$i+1,
                'isCaptain' => 1,
            ]);
        }
        for ($i = 5; $i < 7; $i++){
            DB::table('team_details')->insert([
                'id_user' => $i+1,
                'id_team' =>$i-4,
                'isCaptain' => 0,
            ]);
        }
    }
}
