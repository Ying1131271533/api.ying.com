<!doctype html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin2.2</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8, target-densitydpi=low-dpi" />
    {{-- <link rel="shortcut icon" href="/favicon.ico"> --}}

    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="{{ asset('static/admin/lib/xadmin/css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/lib/xadmin/css/xadmin.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/lib/xadmin/css/theme6.css') }}" rel="stylesheet">

    <script src="{{ asset('static/admin/lib/xadmin/lib/layui/layui.js') }}" charset="utf-8"></script>
    <script src="{{ asset('static/admin/lib/xadmin/js/xadmin.js') }}" charset="utf-8"></script>

    <script src="{{ asset('static/common/js/jquery.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('static/common/js/jquery.cookie.js') }}" charset="utf-8"></script>
    <script src="{{ asset('static/common/js/common.js') }}" charset="utf-8"></script>
    <script src="{{ asset('static/common/js/ajax_admin.js') }}" charset="utf-8"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
        <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
        <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
        // console.log(getToken());
        // 验证登录
        isAdminLogin();
    </script>
</head>

<body class="index">
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo">
            <a href="{{ route('admin.home.index') }}">X-admin v2.2</a>
        </div>
        <div class="left_open">
            <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;">+新增</a>
                <dl class="layui-nav-child">
                    <!-- 二级菜单 -->
                    <dd>
                        <a onclick="xadmin.open('最大化','http://www.baidu.com','','',true)">
                        <i class="iconfont">&#xe6a2;</i>弹出最大化</a>
                    </dd>
                    <dd>
                        <a onclick="xadmin.open('弹出自动宽高','http://www.baidu.com')">
                        <i class="iconfont">&#xe6a8;</i>弹出自动宽高</a>
                    </dd>
                    <dd>
                        <a onclick="xadmin.open('弹出指定宽高','http://www.baidu.com',500,300)">
                        <i class="iconfont">&#xe6a8;</i>弹出指定宽高</a>
                    </dd>
                    <dd>
                        <a onclick="xadmin.add_tab('在tab打开','member-list.html')">
                        <i class="iconfont">&#xe6b8;</i>在tab打开</a>
                    </dd>
                    <dd>
                        <a onclick="xadmin.add_tab('在tab打开刷新','member-del.html',true)">
                        <i class="iconfont">&#xe6b8;</i>在tab打开刷新</a>
                    </dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;" id="admin_name">admin</a>
                <dl class="layui-nav-child">
                    <!-- 二级菜单 -->
                    <dd>
                        <a onclick="admin_info()">个人信息</a>
                    </dd>
                    <dd>
                        <a href="javascript:;" onclick="logout()">退出</a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item to-index">
                <a href="{{ route('admin.home.index') }}" target="_blank">前台首页</a>
            </li>
        </ul>

        <script>
            // 获取用户信息
            var admin = getAdmin();
            console.log(admin);
            $('#admin_name').text(admin.name);

            function admin_info() {
                xadmin.open('个人信息', '/user/info');
            }
        </script>
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
    <div class="left-nav">
        <div id="side-nav">
            <ul id="nav">
                <li>
                    <a href="javascript:;">
                        <i class="iconfont left-nav-li" lay-tips="商品管理">&#xe70b;</i>
                        <cite>商品管理</cite>
                        <i class="iconfont nav_right">&#xe6a7;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('分类列表', '/admin/categorys/index', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>分类列表</cite>
                                </a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('品牌列表', '/admin/brands/index', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>品牌列表</cite>
                                </a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('商品列表', '/admin/goods/index', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>商品列表</cite>
                                </a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('商品模型', '/admin/goods/goods_model', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>商品模型</cite>
                                </a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('商品类型', '/admin/goods_types/index', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>商品类型</cite>
                                </a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('商品属性', '/admin/goods_attrs/index', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>属性列表</cite>
                                </a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('商品规格', '/admin/goods_specs/index', true)">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>规格列表</cite>
                                </a>
                            </li>
                        </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
            <ul class="layui-tab-title">
                <li class="home">
                    <i class="layui-icon">&#xe68e;</i>我的桌面
                </li>
            </ul>
            <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd>
                </dl>
            </div>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe src="{{ route('admin.home.welcome') }}" frameborder="0" scrolling="yes" class="x-iframe"
                        id="x-iframe"></iframe>
                </div>
            </div>
            <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <style id="theme_style"></style>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->

    <script>
        // 打开其它页面时，关闭之前的页面窗口
        layui.use(['jquery'], function() {
            var $ = layui.jquery
            $('.sub-menu li a').click(function() {
                var len = $('.layui-tab-title li').length;
                if (len > 2) {
                    $('.layui-tab-title li i:eq(2)').trigger('click');
                }
            });
        });
        // 退出登录
        function logout() {
            $.ajax({
                type: "POST",
                contentType: "application/x-www-form-urlencoded",
                url: '/api/admin/logout',
                beforeSend: function(request) {
                    request.setRequestHeader("Accept", 'application/x.ying.v1+json');
                    request.setRequestHeader("Authorization", 'Bearer ' + getToken());
                },
                success: function(res) {
                    layer.msg(res.msg, {
                        time: 500
                    }, function() {
                        $.removeCookie('admin_login_token', {
                            path: '/'
                        });
                        $(window).attr('location', '/api/admin/login');
                    });
                },
                error: function (res) {
                    layer.msg(res.responseJSON.message);
                }
            });
        }
    </script>

    <script>
        //百度统计可去掉
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</body>

</html>
