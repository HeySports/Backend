<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 

class price_fieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $arr = [5, 7, 11];
        for($j=0; $j< count($arr); $j++){
            for ($i = 0; $i < 6; $i++){
                $fixed_price = 200000;
                if($arr[$j]==7){
                    $fixed_price = $fixed_price*1.5;
                }else if($arr[$j]==11){
                    $fixed_price = $fixed_price*2.5;
                }
                switch ($i+1) {
                    case 1:
                        case 2:
                            case 5:
                     $fixed_price = $fixed_price+50000;
                      break;
                    case 6:
                        case 4:
                        $fixed_price = $fixed_price+25000;
                      break;
                    case 7:
                        $fixed_price = $fixed_price+20000;
                      break;
                  }
                    DB::table('price_fields')->insert([
                        'id_field' => $i+1,
                        'type_field' => $arr[$j],
                        'time_start' =>  '05:00:00',
                        'time_end' =>  '07:00:00',
                        'price'=> $fixed_price,
                    ]);
                    DB::table('price_fields')->insert([
                        'id_field' => $i+1,
                        'type_field' => $arr[$j],
                        'time_start' =>  '07:00:00',
                        'time_end' =>  '09:00:00',
                        'price'=>  $fixed_price,
                    ]);
                    DB::table('price_fields')->insert([
                        'id_field' => $i+1,
                        'type_field' => $arr[$j],
                        'time_start' =>  '09:00:00',
                        'time_end' =>  '15:00:00',
                        'price'=>  $fixed_price,
                    ]);
                    DB::table('price_fields')->insert([
                        'id_field' => $i+1,
                        'type_field' => $arr[$j],
                        'time_start' =>  '15:00:00',
                        'time_end' =>  '18:00:00',
                        'price'=>  $fixed_price,
                    ]);
                    DB::table('price_fields')->insert([
                        'id_field' => $i+1,
                        'type_field' => $arr[$j],
                        'time_start' =>  '18:00:00',
                        'time_end' =>  '21:00:00',
                        'price'=>  $fixed_price,
                    ]);
                
            }
        }
    }
    
}
