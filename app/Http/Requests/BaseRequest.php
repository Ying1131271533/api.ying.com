<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 获取验证错误的自定义属性
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'          => '名称',
            'email'         => '邮箱',
            'password'      => '密码',
            'parent_id'     => '父级',
            'status'        => '状态',
            'level'         => '级别',
            'user_id'       => '用户',
            'category_id'   => '分类',
            'goods_id'      => '商品id',
            'description'   => '描述',
            'price'         => '价格',
            'stock'         => '库存',
            'cover'         => '封面',
            'pics'          => '详情图集',
            'is_on'         => '是否上架',
            'is_recommend'  => '是否推荐',
            'details'       => '详情',
            'reply'         => '回复',
            'express_type'  => '快递类型',
            'express_no'    => '快递单号',
            'url'           => '链接',
            'img'           => '图片',
            'sort'          => '排序',
            'old_password'  => '旧密码',
            'phone'         => '电话',
            'avatar'        => '头像',
            'number'        => '数量',
            'account'       => '账号',
            'address'       => '地址',
            'address_id'    => '地址id',
            'citie'         => '地区',
            'citie_code'    => '地区代码',
            'content'       => '内容',
            'rate'          => '评价等级',
            'star'          => '评价星级',
            'sort'          => '排序',
            'cn_name'       => '中文名称',
            'file_type'     => '文件类型',
            'file'          => '文件',
            'values'        => '属性值',
            'goods_type_id' => '商品类型id',
            'input_type'    => '录入方式',
            'attributes'    => '商品属性',
            'specs'         => '商品规格',
        ];
    }
}
