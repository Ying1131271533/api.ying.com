<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Rules\CategoryCheckLevel;
use Illuminate\Validation\Rule;

class CategoryRequest extends BaseRequest
{
    /**
     * 获取已定义验证规则
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = array_merge($this->scene(), [
            'parent_id' => 'integer',
            // 'parent_id' => ['integer', new CategoryCheckLevel],
            'status'    => 'integer|in:0,1',
            'group'    => 'max:100',
        ]);
        return $rules;
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'status.in' => '状态必须是0或1',
        ];
    }

    /**
     * 验证场景
     *
     * @return array
     */
    protected function scene()
    {
        // 获取路由名称
        $routeName = $this->route()->getAction('as');
        switch ($routeName) {
            case 'categorys.store':
                return [
                    'name' => 'required|max:20|unique:categories',
                ];
                break;
            case 'categorys.update':
                return [
                    // 'id'   => 'required|integer|gt:0|exists:categories,id',
                    'name' => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('categories')
                            ->ignore($this->category), // 检查唯一性时，排除自己
                    ],
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
