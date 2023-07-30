<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateGoods implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('goods', function (Mapping $mapping, Settings $settings) {
            $mapping->integer('id');
            $mapping->text('title', ['analyzer' => 'ik_max_word', 'search_analyzer' => 'ik_smart']);
            $mapping->integer('category_id');
            $mapping->integer('brand_id');
            $mapping->float('market_price');
            $mapping->float('shop_price');
            $mapping->integer('stock');
            $mapping->integer('sales');
            $mapping->integer('is_on');
            $mapping->integer('is_recommend');
            $mapping->date('created_at');
            $mapping->date('updated_at');
            $mapping->integer('is_on'); // 增加字段
            $mapping->integer('is_recommend');

            $mapping->nested('skus', [
                'properties' => [
                    'name' => [
                        'type' => 'text',
                        'analyzer' => 'ik_smart',
                    ],
                    'price' => [
                        'type' => 'scaled_float', // scaled_float 缩放类型的的浮点数 12.34会存为1234
                        'scaling_factor' => 100,
                    ],
                ]
            ]);
            /* "skus" => array:6 [
                0 => array:2 [
                    "name" => "皓月银 I5/16GB/512GB 触屏 集成显卡 官方标配"
                    "price" => "6299.00"
                ]
                1 => array:2 [
                    "name" => "皓月银 I7/16GB/512GB 触屏 集成显卡 官方标配"
                    "price" => "6599.00"
                ]
            ] */

            $mapping->nested('attributes', [
                'properties' => [
                    'name' => [
                        'type' => 'keyword',
                    ],
                    'value' => [
                        'type' => 'keyword',
                    ],
                ]
            ]);
            /* "attributes" => array:12 [
                0 => array:2 [
                  "name" => "颜色"
                  "value" => "星际蓝"
                ]
                1 => array:2 [
                  "name" => "颜色"
                  "value" => "冰霜银"
                ]
            ] */

            $settings->index([
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
                // 刷新数据，默认为1秒，批量添加数据时可以设为 -1 ，将不会刷新数据
                // 添加完数据后再修改为 1s
                'refresh_interval' => -1
            ]);
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('goods');
    }
}
