<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class GoodsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->scene();
    }

    /**
     * 验证场景
     *
     * @return array
     */
    protected function scene()
    {
        // 获取路由名称
        $routeName = Route::current()->action['as'];
        switch ($routeName) {
            case 'categorys.store':
                return [
                    'name'       => 'required|max:20|unique:categorys',
                    'parent_id'     => 'integer|gt:0|exists:categorys,id',
                    'category_id' => 'integer|gt:0|exists:categorys,id',
                    'content'     => 'min:4',
                ];
                break;
            case 'categorys.update':
                return [
                    'id'          => 'required|integer|gt:0',
                    'user_id'     => 'required|integer|gt:0|exists:users,id',
                    'category_id' => 'required|integer|gt:0|exists:categorys,id',
                    'title'       => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('categorys')->ignore($this->id), // 检查唯一性时，排除自己
                    ],
                    'content'     => 'required|min:4',
                ];
                break;
            default:
                return ['validate_error' => 'required'];
                break;

        }
    }
}
