
/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 数据保存(添加)
 *
 * @param  obj      form            layui表单实例
 * @param  string 	url             提交的url
 * @param  string   back_url        要返回的页面
 */
function layui_ajax_save(form, url, back_url = null) {
    form.on('submit(formSubmit)', function (data) {
        console.log(data);
        // return false;
        // 发异步，把数据提交给php
        $.ajax({
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            url: url,
            data: data.field,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg(res.msg, { icon: 1, time: 500 }, function () {
                    if (back_url) {
                        window.location.href = back_url;
                        return false;
                    }
                    location.reload();
                });

            }
        });

        return false;
    });
}


/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 数据更新
 *
 * @param  obj      form            layui表单实例
 * @param  string 	url             提交的url
 * @param  string   back_url        要返回的页面
 */
function layui_ajax_update(form, url, back_url) {
    form.on('submit(formSubmit)', function (data) {
        // console.log(data);
        //发异步，把数据提交给php
        $.ajax({
            type: "PUT",
            contentType: "application/x-www-form-urlencoded",
            url: url,
            data: data.field,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg(res.msg, { icon: 1, time: 500 }, function () {
                    if (back_url) {
                        window.location.href = back_url;
                        return false;
                    }
                    location.reload();
                });
            }
        });

        return false;
    });
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * layui表单删除单条数据
 *
 * @param  obj      obj     当前元素
 * @param  string 	url     提交的url
 */
function layui_form_delete(obj, url) {

    layer.confirm('确认要删除吗？', function (index) {
        // 发异步删除数据
        $.ajax({
            type: "DELETE",
            url: url,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg(res.msg, { icon: 1, time: 500 }, function () {
                    $(obj).parents("tr").remove();
                });
            }
        });
    });
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 上传图片
 *
 * @param  obj      upload      layui的上传文件对象
 * @param  string 	name        接收图片的input名称
 */
function layui_upload_image(upload, name = 'image', id = 'upload') {
    //执行实例
    var uploadInst = upload.render({
        elem: '#'+id+'-img' // 绑定元素
        , url: '/upload/file' // 上传接口
        , method: 'POST'  // 可选项。HTTP类型，默认post
        , data: { type: 'images' } // 可选项。额外的参数，如：{id: 123, abc: 'xxx'}
        , field: 'images' // 上传文件的字段名
        , headers: { 'access-token': getToken() }
        , before: function (obj) {
            // 预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#'+id+'-preview').attr('src', result); // 图片链接（base64）
            });
            // layer.msg('上传中', {icon: 16, time: 0});
        }
        , done: function (res) {
            // 上传完毕回调
            if (res.code !== config('success')) {
                layer.msg(res.msg, { icon: 2 });
                return false;
            }
            layer.msg('上传成功', { icon: 1, time: 500 });
            $('input[name="' + name + '"]').val(res.data.path);
        }
        , error: function () {
            // 请求异常回调
            layer.msg('上传失败', { icon: 2 });
        }
    });
}


/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 上传多张图片
 *
 * @param  obj      upload      layui的上传文件对象
 * @param  string 	name        接收图片的input名称
 * @param  string 	multiple    是否上传多张图片
 */
function layui_upload_imgs(upload, name='imgs', multiple = false) {
    //执行实例
    var uploadInst = upload.render({
        elem: '#upload-img' // 绑定元素
        , url: '/upload/file' // 上传接口
        , multiple: multiple // 上传多张图片
        , method: 'POST'  // 可选项。HTTP类型，默认post
        , data: { type: 'images' } // 可选项。额外的参数，如：{id: 123, abc: 'xxx'}
        , field: 'images' // 上传文件的字段名
        , headers: { 'access-token': getToken() }
        , before: function (obj) {
            // 预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#upload-preview').append('<img src="' + result + '" alt="' + file.name + '" class="layui-upload-img">')
            });
        }
        , done: function (res) {
            // 上传完毕回调
            if (res.code !== config('success')) {
                layer.msg(res.msg, { icon: 2 });
                return false;
            }
            layer.msg('上传成功', { icon: 1, time: 500 });
            for(let value of res.data.path){
                $('.layui-upload').append('<input type="hidden" name="'+name+'[]" value="'+value+'">');
            }
        }
        , error: function () {
            // 请求异常回调
            layer.msg('上传失败', { icon: 2 });
        }
    });
}