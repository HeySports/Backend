<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class detail_notificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 200; $i++){
            DB::table('detail_notifications')->insert([
                'id_user' => rand(1, 10),
                'id_notification' => rand(1, 20),
                'status' => rand(0,2),
            ]);
        }
    }
}
