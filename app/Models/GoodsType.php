<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model
{
    use HasFactory;

    // 不可以批量赋值的属性。 给空数组
    protected $guarded = [];



    /**
     * 获取这个商品类型的所有商品属性
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * 获取这个商品类型的所有商品规格
     */
    public function specs()
    {
        return $this->hasMany(Spec::class);
    }
}
