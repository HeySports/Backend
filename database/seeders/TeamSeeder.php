<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
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
        'https://lh3.googleusercontent.com/proxy/bUwLSOBI-CdiCvk_hawKQYF0plysOBssrMfW9t_ggxHejOJdhDzmTYpSIr-u5psTf-AkyJEDucIz2BM2XxAfX64iZq5-hTdwHWrv', 
        'https://lh3.googleusercontent.com/proxy/ooPOYHTpc0bNU5lMKn0OumQkVm3RvwA_kIvmj1uPIxCFoG-Ad9BOEDiErh1l1n68tnas1vgbUt79UVoc5WIY0xLezyfwnePfuyzWhqnVEkgfZ4jgV3DySw',
        'https://file.hstatic.net/1000261193/file/bulbal_prime_mufc_cup_lan_v_2_b811a785e80641b6a6430ceba03efc5f_grande.jpg'];
        for ($i = 0; $i < 10; $i++){
            DB::table('teams')->insert([
                'name' => $_arr[rand(0,4)],
                'address' =>$_address[$i],
                'image'=>$_team[rand(0,4)],
                'create_by'=>rand(1, 20),
                'description' => Str::random(50),
                'rating' => rand(1,5),
                'rating_number' => rand(1,5),
              
            ]);
        }
    }
}
