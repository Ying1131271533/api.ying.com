<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    // 不可以批量赋值的属性。 给空数组
    protected $guarded = [];

    // 类型转换，这里竟然是修改和访问共用的
    protected $casts = [
        'values'  => 'array',
    ];

    // 追加字段
    protected $appends = [
        'input_type_name',
    ];

    /**
     * 获取属性输入方式的名称
     */
    protected function inputTypeName(): CastsAttribute
    {
        $type_name = ['手工录入', '从下面的列表中选择', '多行文本框'];
        return new CastsAttribute(
            get: fn ($value) => $type_name[$this->input_type],
        );
    }

    /**
     * 获取这个商品属性所属的商品类型
     */
    public function goodsType()
    {
        return $this->belongsTo(GoodsType::class);
    }
}
