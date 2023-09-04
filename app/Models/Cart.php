<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;

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
        'spec',
        'spec_name',
        'number',
        'is_checked',
    ];

    // 追加字段
    protected $appends = [
        // 'goods_specs', // 好像不需要
    ];

    /**
     * 获取选中的规格
     */
    // protected function showSpecs(): CastsAttribute
    // {
    //     // 处理规格的显示
    //     $spec_ids   = explode('_', $this->spec);
    //     $spec_items = SpecItem::whereIn('id', $spec_ids)
    //         ->with('spec')
    //         ->get();
    //     $goods_specs = [];
    //     foreach ($spec_items as $value) {
    //         $goods_specs[] = [
    //             $value->spec->name => $value->name,
    //         ];
    //     }
    //     return new CastsAttribute(
    //         get: fn ($value) => $goods_specs,
    //     );
    // }

    // 获取选中的规格值的图片
    // protected function showItemPic(): CastsAttribute
    // {
    //     // 处理规格的显示
    //     $spec_ids   = explode('_', $this->spec);
    //     $spec_item_pic = GoodsSpecItemPic::where('spec_item_id', $spec_ids[0])
    //     ->where('goods_id', $this->goods_id)
    //     ->value('path');
    //     return new CastsAttribute(
    //         get: fn ($value) => $spec_item_pic,
    //     );
    // }

    /**
     * 获取这个购物车所属的商品
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
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
