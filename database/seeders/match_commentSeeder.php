<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class match_commentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++){
            DB::table('match_comments')->insert([
                'id_user' => rand(1,10),
                'id_match' => rand(1, 20),
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'description' =>('Trận đấu rất hay có nhiều cầu thủ giỏi thái độ tích cực'),
            ]);
        }
    }
}
