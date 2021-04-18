<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class match_commentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++){
            DB::table('match_comments')->insert([
                'id_user' => rand(1, 3),
                'id_match' => rand(1, 3),
                'description' =>('Trận đấu rất hay có nhiều cầu thủ giỏi thái độ tích cực'),
            ]);
        }
    }
}
