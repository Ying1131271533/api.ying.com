<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class CategoryCheckLevel implements DataAwareRule, InvokableRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    /**
     * 访问所有其他正在验证的数据
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $level = $value == 0 ? 1 : Category::find($value)->level + 1;
        // 加入level
        request()->offsetSet('level', $level);
        // dd(request()->input());
        if ($level > 3) {
            $fail('分类等级不能大于3级');
        }
    }
}
