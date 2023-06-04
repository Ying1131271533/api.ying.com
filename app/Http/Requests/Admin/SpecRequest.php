<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class SpecRequest extends BaseRequest
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
            'is_index.in'   => '检索必须是0或1',
            'input_type.in' => '检索必须是1,2,3',
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
            case 'specs.store':
                return [
                    'goods_type_id' => 'required|integer|gt:0|exists:goods_types,id',
                    'name'          => 'required|max:25',
                    'spec_items'    => 'required|array|max:255',
                ];
                break;
            case 'specs.update':
                return [
                    'goods_type_id' => 'required|integer|gt:0|exists:goods_types,id',
                    'name'          => 'required|max:25',
                    'spec_items'    => 'required|array|max:255',
                ];
                break;
            case 'specs.sort':
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
