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
        $routeName = $this->route()->getAction('as');
        switch ($routeName) {
            case 'slides.store':
                return [
                    'name' => 'required|max:100|unique:slides',
                    'img'  => 'required',
                    'url'  => 'max:255',
                ];
                break;
            case 'slides.update':
                return [
                    'name' => [
                        'required',
                        'max:100',
                        Rule::unique('slides')->ignore($this->slide), // 检查唯一性时，排除自己
                    ],
                    'img'  => 'required',
                    'url'  => 'max:255',
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
