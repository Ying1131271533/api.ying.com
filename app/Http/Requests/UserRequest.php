<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = array_merge([], $this->scene());
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
            'old_password.current_password' => '旧密码验证失败',
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
        $routeName = $this->route()->getName();
        switch ($routeName) {
            case 'user.updateInfo':
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'max:16',
                        Rule::unique('users')->ignore(auth('api')->id()), // 检查唯一性时，排除自己
                    ],
                ];
                break;
            case 'auth.updatePassword':
                return [
                    'old_password' => 'required|min:6|max:50|current_password:api',
                    'password'     => 'required|min:6|max:50|confirmed', // 必须有 password_confirmation
                ];
                break;
            case 'auth.emailCode':
                return [
                    'email' => 'required|email|unique:users,email',
                ];
                break;
            case 'auth.updateEmail':
                return [
                    'email' => 'required|email|unique:users,email',
                    'code'  => 'required|digits:4',
                ];
                break;
            case 'auth.phoneCode':
                return [
                    'phone' => 'required|regex:/^1[3-9]\d{9}$/|unique:users,phone',
                ];
                break;
            case 'auth.updatePhone':
                return [
                    'phone' => 'required|regex:/^1[3-9]\d{9}$/|unique:users,phone',
                    'code'  => 'required|digits:4',
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
