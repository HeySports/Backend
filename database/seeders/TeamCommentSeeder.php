<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TeamCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++){
            DB::table('team_comments')->insert([
                'id_user' => rand(1,99),
                'id_team' => rand(1, 10),
                'rating'=>rand(2,4),
                'description' =>'Đội thái độ tích cực',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addHours($i+2)
            ]);
        }
        for ($i = 0; $i < 100; $i++){
            DB::table('team_comments')->insert([
                'id_user' => rand(1,99),
                'id_team' => rand(1, 49),
                'rating'=>rand(2,4),
                'description' =>'Các bạn trong đội rất hòa đồng',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addHours($i+2)
            ]);
        }
    }
}
