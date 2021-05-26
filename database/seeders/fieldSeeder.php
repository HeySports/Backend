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
        $_name=['Sân bóng đá mini Trung Nghĩa','Sân bóng đá mini Trường CĐ Thương Mai', 'Sân bóng đá Chuyên Việt','Sân bóng đá làng thể thao Tuyên Sơn',
         'Trung Vuong football field',' Sân bóng Trang Hoàng', 'Sân bóng đá Mỹ Nhật Quang', 'Trung tâm bóng đá Duy Tân','Sân bóng đá An Phúc 2',
         'Sân bóng Đức Nam','Sân bóng Hồng Phúc','Sân bóng mini Tuấn Nhàn','Sân bóng đá cỏ nhân tạo','Football pitch Van Dan', 'Sân bóng đá mini Đa Phước',
        'Sân bóng mini Hoà Xuân','Sân bóng mini Bin Bon','Sân bóng An Trung','Sân bóng đá mini trường ĐH Thể Dục Thể Thao Đà Nẵng'];

        $_address=['Hoà Minh, Liên Chiểu, Đà Nẵng','45 Dũng Sĩ Thanh Khê, Thanh Khê, ĐN', '98 Tiểu La, Hoà Thuận Đông, Hải Châu, ĐN','22 Đ 2/9, Bình Hiên, Hải Châu, ĐN',
         '403 Trưng Nữ Vương, Hoà Thuận Nam, Hải Châu, ĐN',' 86 Duy Tân, Hoà Thuận Nam, Hải Châu, ĐN', '498 Nguyễn Hữu Thọ, Khuê Trung, Cẩm Lệ, ĐN', '07 Duy Tân, Hoà Cường Bắc, Hải Châu, ĐN','409 Trưng Nữ Vương, Hoà Thuận Nam, Hải Châu, ĐN',
         '146 Duy Tân, Hoà Thuận Nam, Hải Châu, ĐN','Thanh Khê Đông, Thanh Khê, ĐN','Nguyễn Văn Tạo, Hoà An, Cẩm Lệ, ĐN','243 Trường Chinh, An Khê, Thanh Khê, ĐN','Bế Văn Đàn, Chính Gián, Thanh Khê, ĐN', 'SNguyễn Tất Thành, khu đô thị Đa Phước, Hải Châu, ĐN',
        '08 Nguyễn Phước Lan, Hoà Xuân, Cẩm Lê, ĐN','38 Ông Ích Đường, Khuê Trung, Cẩm Lệ, ĐN','An Trung 3, An Hải Tây, Sơn Trà, ĐN','44 Dũng Sĩ Thanh Khê, Thanh Khê Đông, Thanh Khê, ĐN'];

        $long=[16068939,16073887, 16046397, 16035003, 16048606, 16051262,16031422, 16049999
        ,16046966, 16053344, 160071391, 16055177,16050691
        ,16066359,16077608   ,16024408
        ,16019858 ,16057495, 16071960 ];
        $lat=[108170022 ,108177318 ,108214454 ,108226816 ,108210098 ,108211693 ,108207945 ,108215703 ,108211627 ,
        108206614 ,108183363 ,108174595 ,108183668 ,108194122 ,108204987 ,108224250 ,108204066 ,108234181 ,108180323];

        $_phone=['0911313035','0946795885','0978855426','05113630666','0904239485','02366558787','02363671477','02366555197','02363606461','0905222205','0327948028','02363663758','0982059294','0905121680','0905999933','0901985896','0918085282','0918085082','0905884539'];
        $credit=['0041000349834','0041000613605','0041000613604','0041000613603','0041000613602','0041000613601'];

        for($i = 0; $i < 19; $i++){
            DB::table('fields')->insert([
                'id_owner' => rand(1, 3),
                'name' => $_name[$i],
                'rating' => rand(1,5),
                'rating_number'=>rand(1, 5),
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
