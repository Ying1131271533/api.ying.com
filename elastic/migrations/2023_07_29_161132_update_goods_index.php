<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class UpdateGoodsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        // 更新映射
        // Index::putMapping('goods', function (Mapping $mapping) {
        //     // $mapping->text('title', ['analyzer' => 'standard']); // 字段类型不能修改
        //     $mapping->integer('view'); // 加一个字段
        // });
        // 更新设置
        Index::putSettings('goods', function (Settings $settings) {
            $settings->index([
                // 'number_of_replicas' => 0,
                'refresh_interval' => '1s'
            ]);
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        //
    }
}
