<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsSpecItemPic extends Model
{
    use HasFactory;

    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = false;

    // 不可以批量赋值的属性。 给空数组
    protected $guarded = [];

    /**
     * 允许批量保存的字段
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'goods_id',
    //     'spec_item_id',
    //     'path',
    // ];
}
