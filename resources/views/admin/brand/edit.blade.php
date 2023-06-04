@extends('admin.layout.app')

@section('title', '品牌更新')

<!-- 主体内容 -->
@section('content')
<div class="layui-fluid">
    <div class="layui-form" lay-filter="form">
        <form action="" method="post" name="example">
            <table class="layui-table" lay-size="lg" lay-skin="line">
                <thead>
                    <tr>
                        <th colspan="2">品牌更新</th>
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
                                <input type="hidden" name="id">
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
        $ = layui.jquery;
        var form = layui.form,
            upload = layui.upload,
            layer = layui.layer;

        // 获取数据
        let data = ajax_read('/api/admin/brands', true);
        // 获取id
        var id = get_url_id();

        // 赋值
        form.val("form", data);

        // 更新数据
        layui_ajax_update(form, '/api/admin/brands/' + id);

    });
</script>
@endsection
