<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
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
        $rules = array_merge([
            'category_id'  => 'required|integer|gt:0|exists:categories,id',
            'title'        => 'required|max:191',
            'description'  => 'required|max:255',
            'price'        => 'required|min:0',
            'stock'        => 'required|min:0',
            'cover'        => 'required',
            'pics'         => 'required|array',
            'is_on'        => 'in:0,1',
            'is_recommend' => 'in:0,1',
            'details'      => 'required',
        ], $this->scene());
        return $rules;
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
            case 'goods.store':
                return [
                    'title' => 'required|max:255|unique:goods',
                ];
                break;
            case 'goods.update':
                return [
                    'title' => [
                        'required',
                        'max:255',
                        Rule::unique('goods')
                            ->ignore($this->good), // 检查唯一性时，排除自己
                    ],
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
