<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AkaliRequest extends BaseRequest
{
    /**
     * 获取应用于该请求的验证规则。
     *
     * @return array
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
            'title.required' => '标题不能为空',
            'title.min'      => '标题不能少于4位字符',
            'title.max'      => '标题不能大于于32位字符',
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
            case 'article.store':
                return [
                    'id'    => 'required|integer|gt:0|exists:articles,id',
                    'title' => [
                        'required',
                        'min:4',
                        'max:32',
                    ],
                ];
                break;
            case 'article.update':
                return [
                    'id'    => 'required|integer|gt:0|exists:articles,id',
                    'title'  => [
                        'required',
                        'min:4',
                        'max:32',
                        Rule::unique('articles')->ignore($this->id), // 检查唯一性时，排除自己
                    ],
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
