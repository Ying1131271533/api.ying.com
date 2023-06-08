<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class SpecItemIsEmpty implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
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
        foreach ($value as $spec_item) {
            // 规格项是否为空
            if(empty($spec_item)) return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '规格项不能为空项！';
    }
}
