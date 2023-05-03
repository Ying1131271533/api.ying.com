<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citie extends Model
{
    use HasFactory;

    /**
     * 分类的子类
     */
    public function children()
    {
        return $this->hasMany(Citie::class, 'parent_code', 'code');
    }

    /**
     * 分类的父级数据
     */
    public function parent()
    {
        return $this->belongsTo(Citie::class, 'parent_code', 'code');
    }
}
