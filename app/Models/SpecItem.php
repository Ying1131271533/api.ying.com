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
}
