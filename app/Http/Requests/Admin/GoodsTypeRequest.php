<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class GoodsTypeRequest extends BaseRequest
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
        $route_name = $this->route()->getName();
        switch ($route_name) {
            case 'goods-types.store':
                return [
                    'name' => 'required|max:25|unique:goods_types',
                ];
                break;
            case 'goods-types.update':
                return [
                    'name' => [
                        'required',
                        'max:25',
                        Rule::unique('goods_types')
                            ->ignore($this->goods_type), // 检查唯一性时，排除自己
                    ],
                ];
                break;
                break;

        }
    }
}
