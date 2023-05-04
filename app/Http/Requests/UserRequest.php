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
            'email.exists' => '邮箱未注册',
            'email.unique' => '邮箱已被使用',
            'phone.exists' => '手机未注册',
            'phone.unique' => '手机已被使用',
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
            case 'user.updateAvatar':
                return [
                    'avatar' => 'required|max:191',
                ];
                break;
            case 'auth.updatePassword':
                return [
                    'old_password' => 'required|min:6|max:50|current_password:api',
                    'password'     => 'required|min:6|max:50|confirmed', // 必须有 password_confirmation 字段
                ];
                break;
            case 'auth.emailCode':
                return [
                    'email' => 'required|email',
                ];
                break;
            case 'auth.updateEmail':
                return [
                    'email' => 'required|email|unique:users,email',
                    'code'  => 'required|digits:4',
                ];
            case 'auth.phoneCode':
                return [
                    'phone' => 'required|regex:/^1[3-9]\d{9}$/|unique:users',
                ];
                break;
            case 'auth.updatePhone':
                return [
                    'phone' => 'required|regex:/^1[3-9]\d{9}$/|unique:users',
                    'code'  => 'required|digits:4',
                ];
                break;
            case 'auth.resetPassword.emailCode':
                return [
                    'email' => 'required|email|exists:users',
                ];
                break;
            case 'auth.resetPasswordByEmail':
                return [
                    'password' => 'required|min:6|max:50|confirmed', // 必须有 password_confirmation 字段
                ];
                break;
            case 'auth.resetPassword.smsCode':
                return [
                    'phone' => 'required|regex:/^1[3-9]\d{9}$/|exists:users',
                ];
                break;
            case 'auth.resetPasswordBySms':
                return [
                    'password' => 'required|min:6|max:50|confirmed', // 必须有 password_confirmation 字段
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
