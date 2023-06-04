<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * 不可以批量赋值的属性。 给空数组 那就是所有属性都可以赋值
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获取这个品牌的所有商品
     */
    public function goods()
    {
        return $this->hasMany(Good::class);
    }
}
