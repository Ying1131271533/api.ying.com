<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends BaseRequest
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
        $routeName = $this->route()->action['as'];
        switch ($routeName) {
            case 'categorys.store':
                return [
                    'name'      => 'required|max:20|unique:categorys',
                    'parent_id' => 'integer',
                    'status'    => 'integer|in:0,1',
                    'level'     => 'integer|gt:0',
                ];
                break;
            case 'categorys.update':
                return [
                    'id'          => 'required|integer|gt:0|exists:users,id',
                    'name'       => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('categorys')->ignore($this->id), // 检查唯一性时，排除自己
                    ],
                    'parent_id'     => 'required|integer|gt:0|exists:users,id',
                    'status'    => 'integer|in:0,1',
                    'level'     => 'integer|gt:0',
                ];
                break;
            default:
                return ['validate_error' => 'required'];
                break;

        }
    }
}
