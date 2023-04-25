<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    use HasFactory;

    /**
     * 不可以批量赋值的属性。
     * 给空数组 既是所有属性都可以赋值
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    // protected $fillable = [
    //     'order_no',
    //     'user_id',
    //     'amount',
    //     'status',
    //     'address_id',
    //     'express_type',
    //     'express_no',
    //     'pay_time',
    //     'pay_type',
    //     'trade_no',
    // ];

    /**
     * 获取支付类型 - 这种只能访问表存在的字段
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function payType(): Attribute
    {
        return new Attribute(
            get: fn ($value) => pay_type_name($value),
        );
    }

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

    /**
     * 订单远程一对多，关联的商品
     */
    public function goods(): HasManyThrough
    {
        return $this->hasManyThrough(
            Good::class, // 要远程访问的最终模型
            OrderDetails::class, // 中间模型
            'order_id', // 中间模型和本模型关联的外键
            'id', // 最终关联模型的本地键
            'id', // 本模型和中间模型关联的本地键
            'goods_id' // 中间表和最终模型关联的一个外键
        );
    }
}
