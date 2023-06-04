<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\UploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UploadController extends BaseController
{
    /**
     * 上传文件
     */
    public function __invoke(UploadRequest $request)
    {
        // 获取验证参数
        $validated = $request->validated();
        // 获取上传的文件类型名称
        $file_type = $validated['file_type'];
        // 获取上传文件的实例
        $file = $validated['file'];
        // 多个文件，需要这样才能获取到
        // return $file[0];
        // 获取文件后缀名
        // $extension = $file->extension();
        // 上传文件
        try {
            if (is_array($file)) { // 多个文件
                $path = [];
                foreach ($file as $value) {
                    // 验证文件
                    $this->validateFile($value, $file_type);
                    // 保存文件，获取文件路径
                    $path[] = 'storage/' . $value->store($file_type . 's/' . date('Ymd'), 'public');
                }
            } else { // 单个文件
                // 验证文件
                $this->validateFile($file, $file_type);
                // 保存文件，获取文件路径
                $path = 'storage/' . $file->store($file_type . 's/' . date('Ymd'), 'public');
            }
            // 返回文件路径
            return $this->response->array(['path' => $path]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 判断文件的类型验证数据
     *
     * @return array
     */
    protected function validateFile($file, $file_type)
    {
        // 判断文件类型
        switch ($file_type) {
            case 'image':
                $rules = [
                    'file' => 'filled|image|max:5120',
                ];
                $message = [
                    'file.image' => '文件必须为图片',
                    'file.max'   => '图片内存大小不能大于5M',
                ];
                break;
            case 'avatar':
                $rules = [
                    'file' => 'filled|image|dimensions:min_width=50,min_height=50,max_width=500,max_height=500|max:1024',
                ];
                $message = [
                    'file.max'        => '头像内存大小不能大于1M',
                    'file.image'      => '文件必须为图片',
                    'file.dimensions' => '头像尺寸不正确，像素最小50x50 至 最大为500x500',
                ];
                break;
            case 'video':
                $rules = [
                    'file' => 'filled|file',
                ];
                $message = [
                    'file.file' => '视频未上传',
                ];
                break;
            case 'excel':
                $rules = [
                    'file' => 'filled|file|mimes:xls,xlsx',
                ];
                $message = [
                    'file.file'  => '表格未上传',
                    'file.mimes' => 'excel表格式必需为xls,xlsx',
                ];
            case 'word':
                $rules = [
                    'file' => 'filled|file|mimes:doc',
                ];
                $message = [
                    'file.file'  => '文档未上传',
                    'file.mimes' => 'excel表格格式必需为doc',
                ];
            case 'file':
                $rules = [
                    'file' => 'filled|file',
                ];
                $message = [
                    'file.file' => '文件未上传',
                ];
                break;
        }
        // 验证数据
        $validator = Validator::make(['file' => $file], $rules, $message, ['file' => '文件']);
        // 验证失败
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    }
}
