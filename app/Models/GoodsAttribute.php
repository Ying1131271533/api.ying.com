<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsAttribute extends Model
{
    use HasFactory;

    // 不可以批量赋值的属性。 给空数组
    protected $guarded = [];

    /**
     * 允许批量保存的字段
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'goods_id',
    //     'attribute_id',
    //     'value',
    // ];

    /**
     * 获取这个商品属性值所属的商品属性
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
