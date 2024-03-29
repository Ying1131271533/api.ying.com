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
        'spec',
        'spec_name',
        'number',
    ];

    /**
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'market_price' => 'decimal:2',
        'show_price' => 'decimal:2',
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
        // return $this->hasOne(Goods::class, 'id', 'goods_id');
        return $this->belongsTo(Goods::class, 'goods_id');
    }
}
