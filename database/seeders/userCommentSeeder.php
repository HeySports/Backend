<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Carbon\Carbon;
class userCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++){
            DB::table('user_comments')->insert([
                'id_user' => rand(1,99),
                'id_user_commented' => rand(1, 99),
                'skill_rating'=>rand(1,10),
                'attitude_rating'=>rand(2,5),
                'description' =>'Bạn thái độ tích cực',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addHours($i+2)
            ]);
        }
        for ($i = 0; $i < 100; $i++){
            DB::table('user_comments')->insert([
                'id_user' => rand(1,99),
                'id_user_commented' => rand(1, 99),
                'skill_rating'=>rand(1,10),
                'attitude_rating'=>rand(2,5),
                'description' =>'Kĩ thuật hơi kém nhưng thái độ ok',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addHours($i+2)
            ]);
        }
    }
}
