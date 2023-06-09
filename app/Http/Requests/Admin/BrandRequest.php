<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends BaseRequest
{
    /**
     * 获取已定义验证规则
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
        $route_name = $this->route()->getName();
        switch ($route_name) {
            case 'brands.store':
                return [
                    'name' => 'required|max:25|unique:brands',
                    'logo'   => 'required|max:100',
                ];
                break;
            case 'brands.update':
                return [
                    'name' => [
                        'required',
                        'max:50',
                        Rule::unique('brands')->ignore($this->brand), // 检查唯一性时，排除自己
                    ],
                    'logo' => [
                        'required',
                        'max:100',
                    ],
                ];
                break;
            case 'brands.sort':
                return [
                    'sort' => 'required|integer|max:99999|min:0',
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
