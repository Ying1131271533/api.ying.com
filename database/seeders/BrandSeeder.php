<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Apple', 'logo' => 'storage/images/20230602/MyUE4EhnfackYreFbSxrv8cMgw4byMtMwOTdcPQH.png'],
            // ['name' => 'Apple', 'logo' => 'http://placeimg.com/640/480/any'],
            ['name' => '小米', 'logo' => 'storage/images/20230601/SPh7d2X1ejbuM1FHSnso1MMaqBnExb8ceidTinc5.jpg'],
            ['name' => '华为', 'logo' => 'storage/images/20230601/GLt7huP5S3Qq3gH79usqqM85JzETzQ9ALSSJHNB2.png'],
            ['name' => '三星', 'logo' => 'storage/images/20230602/pmLheZsS5mN7QuJYGyuYOCoIHBR7SsrkMdotOLcH.jpg'],
            ['name' => '优衣库', 'logo' => 'storage/images/20230602/pmLheZsS5mN7QuJYGyiYOCoIHBR7SsrkMdotOLcL.gif'],
            ['name' => '匡威', 'logo' => 'storage/images/20230602/IyUE4EhnfackYreFbSxrv8cMgw4byMtMwOTdcPQP.png'],
        ];

        foreach ($data as $value) {
            Brand::create($value);
        }

    }
}
