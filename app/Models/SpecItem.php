<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecItem extends Model
{
    use HasFactory;

    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = false;

    // 不可以批量赋值的属性。 给空数组
    protected $guarded = [];

    /**
     * 获取这个规格项所属的商品规格
     */
    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }
}
