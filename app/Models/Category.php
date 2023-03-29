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
        'name',
        'parent_id',
        'level',
        'status',
    ];

    /**
     * 分类的子类
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
