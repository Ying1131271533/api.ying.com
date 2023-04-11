<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'order_no',
        'user_id',
        'amount',
        'status',
        'address_id',
        'express_type',
        'express_no',
        'pay_time',
        'pay_type',
        'trade_no',
    ];

    /**
     * 获取这个订单所属的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取这个订单的所有详情
     */
    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }
}
