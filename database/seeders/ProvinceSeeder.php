<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $provinces = [
                [
                    'province_name' => 'Province No. 1: Koshi',
                    'capital' => 'Biratnagar',
                    'no_of_districts'  => 14,
                    'area' => 25905,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Nepal_Province_No_1_adm_location_map.svg/290px-Nepal_Province_No_1_adm_location_map.svg.png',
                ],
                [
                    'province_name' => 'Province No. 2: Madhesh',
                    'capital' => 'Janakpur',
                    'no_of_districts'  => 8,
                    'area' => 9661,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0a/Nepal_Province_No._2_adm_location_map.svg/290px-Nepal_Province_No._2_adm_location_map.svg.png',
                ],
                [
                    'province_name' => 'Province No. 3: Bagmati',
                    'capital' => 'Hetauda',
                    'no_of_districts'  => 13,
                    'area' => 20300,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/94/Nepal_Bagmati_adm_location_map.svg/290px-Nepal_Bagmati_adm_location_map.svg.png',
                ],
                [
                    'province_name' => 'Province No. 4: Gandaki',
                    'capital' => 'Pokhara',
                    'no_of_districts'  => 11,
                    'area' => 21504,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Nepal_Gandaki_adm_location_map.svg/290px-Nepal_Gandaki_adm_location_map.svg.png',
                ],
                [
                    'province_name' => 'Province No. 5: Lumbini',
                    'capital' => 'Deukhuri ',
                    'no_of_districts'  => 12,
                    'area' => 22288,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Nepal_Lumbini_adm_location_map.svg/290px-Nepal_Lumbini_adm_location_map.svg.png',
                ],
                [
                    'province_name' => 'Province No. 6: Karnali',
                    'capital' => 'Birendranagar',
                    'no_of_districts'  => 10,
                    'area' => 27984,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Nepal_Karnali_adm_location_map.svg/290px-Nepal_Karnali_adm_location_map.svg.png',
                ],
                [
                    'province_name' => 'Province No. 7: Sudurpashchim',
                    'capital' => 'Godawari',
                    'no_of_districts'  => 9,
                    'area' => 19915,
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/df/Nepal_Sudurpashchim_Pradesh_adm_location_map.svg/290px-Nepal_Sudurpashchim_Pradesh_adm_location_map.svg.png',
                ],
            ];

        DB::table('provinces')->insert($provinces);
    }
}
