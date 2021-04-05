<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([roleSeeder::class,userSeeder::class,fieldSeeder::class,child_fieldSeeder::class,matchSeeder::class,price_fieldSeeder::class,
                    match_commentSeeder::class,comments_fieldSeeder::class,detail_matchSeeder::class,notificationSeeder::class, 
                    detail_notificationSeeder::class,orderSeeder::class]);
    }
}
