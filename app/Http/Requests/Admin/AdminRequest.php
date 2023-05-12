<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends BaseRequest
{
    /**
     * 获取已定义验证规则
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = array_merge([
            'password' => 'required|min:6|max:50|confirmed', // 必须有 password_confirmation
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
            case 'admins.store':
                return [
                    'name' => 'required|max:20|unique:admins',
                ];
                break;
            case 'admins.update':
                return [
                    'name' => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('admins')
                            ->ignore($this->admin), // 检查唯一性时，排除自己
                    ],
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
