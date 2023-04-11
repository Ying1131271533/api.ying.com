<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;;

class CommentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'reply' => 'required|max:255',
        ];
    }
}
