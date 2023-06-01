@extends('layout.app')

@section('title', '品牌保存')

<!-- 主体内容 -->
@section('content')
<div class="layui-fluid">
    <div class="layui-form" lay-filter="form">
        <form action="" method="post" name="example">
            <table class="layui-table" lay-size="lg" lay-skin="line">
                <thead>
                    <tr>
                        <th colspan="2">品牌保存</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="150" align="right"><strong>品牌名称：</strong></td>
                        <td>
                            <div class="layui-input-inline">
                                <input class="layui-input" type="text" name="name" placeholder="品牌名称">
                            </div>
                            <div class="layui-input-inline">
                                <span style="color: red;">*</span>  例如：优衣库
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right"><strong>品牌Logo：</strong></td>
                        <td>
                            <div class="layui-input-inline">
                                <input class="layui-input" type="text" name="logo" placeholder="logo">
                            </div>
                            <div class="layui-input-inline">
                                <span style="color: red;">*</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"></td>
                        <td>
                            <div class="layui-input-inline">
                                <button class="layui-btn" lay-submit lay-filter="formSubmit">立即提交</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

@endsection

@section('script')

<script>
    layui.use(['form', 'layer'], function () {
        // 表单实例化
        var form = layui.form;
        // 保存
        layui_ajax_save(form, '/api/admin/brands', '/admin/brands/index');
    });
</script>
@endsection
