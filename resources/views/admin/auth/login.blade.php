<!doctype html>
<html class="x-admin-sm">

<head>
  <meta charset="UTF-8">
  <title>后台登录-X-admin2.2</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="{{ asset('static/admin/lib/xadmin/css/font.css') }}">
  <link rel="stylesheet" href="{{ asset('static/admin/lib/xadmin/css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('static/admin/lib/xadmin/css/xadmin.css') }}">
  <script src="{{ asset('static/admin/lib/xadmin/lib/layui/layui.js') }}" charset="utf-8"></script>
  <script src="{{ asset('static/common/js/jquery.min.js') }}" charset="utf-8"></script>
  <script src="{{ asset('static/common/js/jquery.cookie.js') }}" charset="utf-8"></script>
  <script src="{{ asset('static/common/js/common.js') }}" charset="utf-8"></script>

  <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-bg">

  <div class="login layui-anim layui-anim-up">
    <div class="message">X-admin2.0-管理登录</div>
    <div id="darkbannerwrap"></div>

    <form method="post" class="layui-form">
      <input name="username" placeholder="用户名" type="text" lay-verify="required" class="layui-input">
      <hr class="hr15">
      <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
      <hr class="hr15">
      <div class="layui-form-item">
        <div class="layui-input-block" style="margin-left: 0px;">
          <div id="slider"></div>
        </div>
      </div>
      <hr class="hr15">
      <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
      <hr class="hr20">
    </form>
  </div>

  <script type="text/javascript" charset="utf-8">

    // 获取token
    let token = getApiToken();

    layui.config({
      base: '/static/common/lib/dist/sliderVerify/'
    }).use(['sliderVerify', 'jquery', 'form'], function () {

      // 滑块验证
      var sliderVerify = layui.sliderVerify,
        $ = layui.jquery,
        form = layui.form;
      var slider = sliderVerify.render({
        elem: '#slider',
        onOk: function () { // 当验证通过回调
          // layer.msg("滑块验证通过");
        }
      })

      // 是否已登录过
      if (!empty(token)) {
        alert(toekn)
          layer.msg('已登录，无需重复登录', { time: 700 }, function () {
              $(window).attr('location', "{{ route('admin.home.index') }}");
          });
      }

      //监听提交
      form.on('submit(login)', function (data) {
        if (slider.isOk()) {
          // 发异步，把数据提交给php
          $.ajax({
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            url: 'http://api.ying.com/api/auth/login',
            data: {
              account: data.field.username,
              password: data.field.password
            },
            success: function (res) {
                if (res.status_code != 200) {
                    layer.msg(res.msg);
                }

                $.cookie('admin_login_token', res.access_token, { expires: 1 * 365, path: '/' });
                $(window).attr('location', "{{ route('admin.home.index') }}");

                // 下面这提示有点烦~~~
                // layer.msg('登录成功！', {time: 500}, function () {
                //   $.cookie('admin_login_token', res.access_token, { expires: 100 * 365, path: '/' });
                //   $(window).attr('location', "{{ route('admin.home.index') }}");
                // });

            }
          });

        } else {
          layer.msg("请先通过滑块验证");
        }
        return false;
      });

    })
  </script>
  <!-- 底部结束 -->
</body>

</html>
