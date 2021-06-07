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
        $desc=['Rất vui vẻ thân thiện', 'Đá nhiệt tình quán hà', 'Đội thái độ tích cực'];
        for ($i = 0; $i < 40; $i++){
            DB::table('team_comments')->insert([
                'id_user' => rand(1,10),
                'id_team' => rand(1,5),
                'rating'=>rand(2,5),
                'description' =>$desc[rand(0,2)],
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }
}
