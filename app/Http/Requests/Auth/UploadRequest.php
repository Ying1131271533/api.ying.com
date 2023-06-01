<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class UploadRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file_type' => 'required|in:image,avatar,video,excel,word,file',
            'file'      => 'required|filled',
            // 'file'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
    }


    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file_type.in' => '文件类型必须为 image,avatar,video,excel,word,file 其中之一',
        ];
    }
}
