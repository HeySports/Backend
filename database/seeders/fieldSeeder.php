<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_name=['Trung Nghĩa','Thương Mai', 'Chuyên Việt','Tuyên Sơn',
         'Trung Vuong football','Trang Hoàng', 'Mỹ Nhật Quang', 'Duy Tân','An Phúc 2',
         'Đức Nam','Hồng Phúc','Tuấn Nhàn','Sân T20','Football pitch Van Dan', 'Đa Phước',
        'Hoà Xuân','Bin Bon','An Trung','Đại Học Thể Thao'];

        $_address=['Hoà Minh, Liên Chiểu, Đà Nẵng','45 Dũng Sĩ Thanh Khê, Thanh Khê, ĐN', '98 Tiểu La, Hoà Thuận Đông, Hải Châu, ĐN','22 Đ 2/9, Bình Hiên, Hải Châu, ĐN',
         '403 Trưng Nữ Vương, Hoà Thuận Nam, Hải Châu, ĐN',' 86 Duy Tân, Hoà Thuận Nam, Hải Châu, ĐN', '498 Nguyễn Hữu Thọ, Khuê Trung, Cẩm Lệ, ĐN', '07 Duy Tân, Hoà Cường Bắc, Hải Châu, ĐN','409 Trưng Nữ Vương, Hoà Thuận Nam, Hải Châu, ĐN',
         '146 Duy Tân, Hoà Thuận Nam, Hải Châu, ĐN','Thanh Khê Đông, Thanh Khê, ĐN','Nguyễn Văn Tạo, Hoà An, Cẩm Lệ, ĐN','243 Trường Chinh, An Khê, Thanh Khê, ĐN','Bế Văn Đàn, Chính Gián, Thanh Khê, ĐN', 'SNguyễn Tất Thành, khu đô thị Đa Phước, Hải Châu, ĐN',
        '08 Nguyễn Phước Lan, Hoà Xuân, Cẩm Lê, ĐN','38 Ông Ích Đường, Khuê Trung, Cẩm Lệ, ĐN','An Trung 3, An Hải Tây, Sơn Trà, ĐN','44 Dũng Sĩ Thanh Khê, Thanh Khê Đông, Thanh Khê, ĐN'];

        $long=['16.068.939','16.073.887', '16.046.397', '16.035.003', '16.048.606', '16.051.262','16.031.422', '16.049.999'
        ,'16.046.966', '16.053.344', '160.071.391', '16.055.177','16.050.691'
        ,'16.066.359','16.077.608'   ,'16.024.408'
        ,'16.019.858' ,'16.057.495', '16.071.960' ];
        $lat=['108.170.022' ,'108.177.318' ,'108.214.454' ,'108.226.816' ,'108.210.098' ,'108.211.693' ,'108.207.945' ,'108.215.703' ,'108.211.627' ,
        '108.206.614' ,'108.183.363' ,'108.174.595' ,'108.183.668' ,'108.194.122' ,'108.204.987' ,'108.224.250' ,'108.204.066' ,'108.234.181' ,'108.180.323'];

        $_phone=['0911313035','0946795885','0978855426','05113630666','0904239485','02366558787','02363671477','02366555197','02363606461','0905222205','0327948028','02363663758','0982059294','0905121680','0905999933','0901985896','0918085282','0918085082','0905884539'];
        $credit=['0041000349834','0041000613605','0041000613604','0041000613603','0041000613602','0041000613601'];

        for($i = 0; $i < 19; $i++){
            DB::table('fields')->insert([
                'id_owner' => rand(1, 3),
                'name' => $_name[$i],
                'rating' => rand(1,5),
                'rating_number'=>rand(1, 10),
                'list_image' => '[]',
                'address' => $_address[$i],
                'longitude'=>$long[$i],
                'latitude'=> $lat[$i],
                'email_field' => Str::random(10) . '@gmail.com',
                'phone_numbers' => $_phone[$i],
                'credit' => $credit[rand(0,5)],
                'status' => 1,
                'quantities_field' => rand(10, 20),
            ]);
        }
        
    }
}
