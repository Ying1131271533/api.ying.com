<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * 不可以批量赋值的属性。
     * 给空数组 既是所有属性都可以赋值
     *
     * @var array
     */
    protected $guarded = [];
}
