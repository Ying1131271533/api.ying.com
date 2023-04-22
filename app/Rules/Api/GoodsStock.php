<?php

namespace App\Rules\Api;

use App\Models\Good;
use Illuminate\Contracts\Validation\Rule;

class GoodsStock implements Rule
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
        $stock = Good::find($this->goods_id)->value('stock');
        // 数量必须少于库存
        return ($value < $stock);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '数量不能大于库存！';
    }
}
