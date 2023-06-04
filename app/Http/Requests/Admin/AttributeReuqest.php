<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AttributeReuqest extends BaseRequest
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
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'input_type.in' => '录入方式必须是1,2,3',
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
        $route_name = $this->route()->getName();
        switch ($route_name) {
            case 'attributes.store':
                return [
                    'goods_type_id' => 'required|integer|gt:0|exists:goods_types,id',
                    'name'          => 'required|max:25',
                    'input_type'    => 'required|in:1,2,3',
                    'values'        => 'array|max:255',
                ];
                break;
            case 'attributes.update':
                return [
                    'goods_type_id' => 'required|integer|gt:0|exists:goods_types,id',
                    'name'          => 'required|max:25',
                    'input_type'    => 'required|in:1,2,3',
                    'values'        => 'array|max:255',
                ];
                break;
            case 'attributes.sort':
                return [
                    'sort' => 'required|integer|max:999999|min:0',
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
