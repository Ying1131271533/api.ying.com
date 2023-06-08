<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    use HasFactory;

    // 不可以批量赋值的属性。 给空数组
    protected $guarded = [];

    /**
     * 获取这个商品规格所属的商品类型
     */
    public function goodsType()
    {
        return $this->belongsTo(GoodsType::class);
    }

    /**
     * 获取这个规格关联的所有规格项
     */
    public function items()
    {
        return $this->hasMany(SpecItem::class);
    }
}
