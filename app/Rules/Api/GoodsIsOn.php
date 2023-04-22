<?php

namespace App\Rules\Api;

use App\Models\Good;
use Illuminate\Contracts\Validation\Rule;

class GoodsIsOn implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected $goods_id)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $goods = Good::find($this->goods_id);
        // 商品必须是上架
        return ($goods->is_on == 1);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '商品已下架';
    }
}
