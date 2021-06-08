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
        $desc= ['Kĩ thuật hơi kém nhưng thái độ ok', 'Bạn thái độ tích cực', 'Nhiệt tình'];
        for ($i = 0; $i < 50; $i++){
            DB::table('user_comments')->insert([
                'id_user' => rand(1,10),
                'id_user_commented' => rand(1, 10),
                'skill_rating'=>rand(1,10),
                'attitude_rating'=>rand(2,5),
                'description' => $desc[rand(0,2)],
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }
}
