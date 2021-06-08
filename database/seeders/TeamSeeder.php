<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Carbon\Carbon;
class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_arr =['PN21 Club', 'Cộng Hòa Team', 'Gà Chiến Mỹ Khê', 'CLB Sơn Trà', 'CLB Hải Sơn Trà','PN22 Club', 'Kiên Giang Team', 'Vô Đối', 'Bất Bại', 'Xóm Ran'];
        $_address=['Sơn Trà', 'Hải Châu', 'Sơn Trà', 'Sơn Trà', 'Hải Châu','Sơn Trà', 'Ngũ Hành Sơn', 'Liên Chiểu', 'Hải Châu', 'Sơn Trà',];
        $_team=[
            'https://bongdadoisong.com/wp-content/uploads/2018/11/45245933_327307784713580_854832593667883008_n-1024x550.jpg',
        'https://bongdadoisong.vn/uploads/news/2020/05/27/anh-em-phui-di-an.jpg',
        'https://vietfootball.vn/data/uploads/2016/08/tra.jpg', 
        'http://baokhanhhoa.vn/dataimages/201807/original/images5338443_IMG_57951111.jpg',
        'https://file.hstatic.net/1000261193/file/bulbal_prime_mufc_cup_lan_v_2_b811a785e80641b6a6430ceba03efc5f_grande.jpg'];
        for ($i = 0; $i < 10; $i++){
            DB::table('teams')->insert([
                'name' => $_arr[$i],
                'address' =>$_address[$i],
                'description' => 'Giao lưu học hỏi',
                'rating' => rand(1,5),
                'rating_number' => rand(1,5),
                'create_by'=>rand(1,9),
                'created_at'=> Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }
}
