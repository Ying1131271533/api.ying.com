<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class SlideRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = array_merge([
            'name' => 'required|max:100',
            'img'  => 'required',
            'url'  => 'max:255',
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
            case 'slides.store':
                return [
                    'name' => 'required|max:100|unique:slides',
                ];
                break;
            case 'slides.update':
                return [
                    'name' => [
                        'required',
                        'max:100',
                        Rule::unique('slides')->ignore($this->slide), // 检查唯一性时，排除自己
                    ]
                ];
                break;
            case 'slides.sort':
                return [
                    'sort' => 'required|integer|gt:0',
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
