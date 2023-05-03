<?php

namespace Database\Seeders;

use App\Models\Citie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建地区表，并填充数据
        DB::unprepared(file_get_contents(__DIR__ . '/../sql/cities.sql'));

        // 创建城市缓存 一次性缓存起来，有点太大
        // $cities = Citie::with('children.children.children')->get();
        // Cache::store('redis')->set('cities_tree', $cities);
    }
}
