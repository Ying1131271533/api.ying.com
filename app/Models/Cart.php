<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Cart extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'goods_id',
        'number',
        'is_checked',
    ];

    /**
     * 获取这个购物车所属的商品
     */
    public function goods()
    {
        return $this->belongsTo(Good::class);
    }

    /**
     * 获取这个购物车所属的商品
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 订单远程一对多，关联的商品的创建用户
     */
    public function goodsUsers(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class, // 要远程访问的最终模型
            Goods::class, // 中间模型
            'goods_id', // 中间模型和本模型关联的外键
            'id', // 最终关联模型的本地键
            'id', // 本模型和中间模型关联的本地键
            'user_id' // 中间表和最终模型关联的一个外键
        );
    }
}
