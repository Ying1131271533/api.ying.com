<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class PermissionRequest extends BaseRequest
{
    public function rules()
    {
        $rules = array_merge([
            'name'    => 'required',
            'cn_name' => 'required',
            'url'     => 'max:191',
            'show'    => 'in:0,1',
            'sort'    => 'integer|max:60000',
            'icon'    => 'max:30',
        ], $this->scene());
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
            'show.in'        => '显示导航 只能为0或1',
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
            case 'categorys.store':
                return [
                    'parent_id' => 'integer',
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
