<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class comments_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++){
            DB::table('comments_field')->insert([
                'id_user' => rand(1, 10),
                'id_field' => rand(1, 18),
                'rating' => rand(2, 5),
                'description' =>  'Sân tốt giá cả hợp lí',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }
}
