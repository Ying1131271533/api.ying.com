<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'level',
        'status',
        'group',
    ];

    /**
     * 分类的子级
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * 分类的父级
     */
    public function parent()
    {
        return $this->hasMany(Category::class, 'id', 'parent_id');
    }

    /**
     * 获取这个分类的所有商品
     */
    public function goods()
    {
        return $this->hasMany(Good::class);
    }
}
