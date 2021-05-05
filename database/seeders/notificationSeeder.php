<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class notificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++){
            DB::table('notifications')->insert([
                'type' => rand(0,1),
                'id_match' => rand(1, 3),
                'description' => 'Sản phẩm rất tốt có thể sử dụng !',
            ]);
        }
    }
}
