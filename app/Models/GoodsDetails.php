<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsDetails extends Model
{
    use HasFactory;

    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 不可以批量赋值的属性。 给空数组 那就是所有属性都可以赋值
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'pics'  => 'array',
    ];

}
