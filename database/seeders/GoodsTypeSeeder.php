<?php

namespace Database\Seeders;

use App\Models\GoodsType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoodsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => '手机'],
            ['name' => '电脑'],
            ['name' => '短袖'],
            ['name' => '短裤'],
        ];

        foreach ($data as $value) {
            GoodsType::create($value);
        }
    }
}
