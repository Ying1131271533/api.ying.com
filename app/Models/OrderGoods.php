<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'goods_id',
        'price',
        'number',
    ];

    /**
     * 获取这个订单详情所属的订单
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 获取这个订单详情所属的商品
     */
    public function goods()
    {
        // return $this->hasOne(Good::class, 'id', 'goods_id');
        return $this->belongsTo(Good::class, 'goods_id');
    }
}
