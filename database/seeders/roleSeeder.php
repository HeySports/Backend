<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name_role' => 'user',
            'description' => Str::random(10),
        ]);
        DB::table('roles')->insert([
            'name_role' => 'admin',
            'description' => Str::random(10),
        ]);
        DB::table('roles')->insert([
            'name_role' => 'owner',
            'description' => Str::random(10),
        ]);
    }
}
