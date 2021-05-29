<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StatusOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_offers')->insert([
            'name' => 'Đang Đợi',
            'description' => 'Đang đợi đội của đội bóng có thể chấp nhận bạn làm thành viên',
        ]);
        DB::table('status_offers')->insert([
            'name' => 'Đã Chấp Nhận',
            'description' => 'Bạn là thành viên của đội bóng',
        ]);
        DB::table('status_offers')->insert([
            'name' => 'Xóa Bỏ',
            'description' => 'Bạn đã không được chấp nhận là thành viên của đội',
        ]);
           
     }
}
