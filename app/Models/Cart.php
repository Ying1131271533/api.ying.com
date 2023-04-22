<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'group',
    ];

    /**
     * 获取这个购物车所属的商品
     */
    public function goods()
    {
        return $this->belongsTo(Good::class);
    }
}
