<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GoodsController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\OssController;

$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => [
        'api.throttle',
        'bindings', // 支持模型注入
        'serializer:default_array', // 去掉 transformer 的包裹层
    ],
    'limit'   => 60, // 有效时间内能够访问的次数
    'expires' => 1, // 有效时间/分钟
];

$api->version('v1', $params, function ($api) {
    // 前缀
    $api->group(['prefix' => 'admin'], function ($api) {

        // 管理员登录
        $api->post('login', [AuthController::class, 'login'])->name('auth.login');

        // 需要登录的路由
        // 这里使用 auth.admin 将会显示 500 Route [login] not defined.
        // 在控制器里面使用中间件，才能正确显示 401 Unauthorized
        // 新情况：必须users和admins都有用户数据，中间这里才能用 api.auth ？
        // $api->group(['middleware' => ['auth:admin']], function ($api) {
        $api->group(['middleware' => ['api.auth']], function ($api) {
        // $api->group(['middleware' => ['api.auth', 'check.permission']], function ($api) {

            // 退出登录
            $api->post('logout', [AuthController::class, 'logout'])->name('auth.logout');

            /**
             * 管理员管理
             */
            // 测试
            $api->get('test', [AdminController::class, 'test'])->name('admins.test');
            // 根据id获取管理员信息
            $api->get('admins/{admin}/get-admin-by-id', [AdminController::class, 'getAdminById'])->name('admins.getAdminById');
            // 获取管理员信息
            $api->get('admins/info', [AdminController::class, 'info'])->name('admins.info');
            // 启用/禁用
            $api->patch('admins/{admin}/lock', [AdminController::class, 'lock'])->name('admins.lock');
            // 资源路由
            $api->resource('admins', AdminController::class);

            /**
             * 角色管理
             */
            // 角色拥有的权限
            $api->get('roles/permissions', [AuthController::class, 'permissions'])->name('role.permissions');
            // 角色赋予权限
            $api->post('grant-permissions', [AuthController::class, 'grantPermissions'])->name('role.grantPermissions');
            // 资源路由
            $api->resource('roles', RoleController::class);

            /**
             * 权限节点管理
             */
            // 显示在导航栏 启用/禁用
            $api->patch('permissions/{permission}/show', [PermissionController::class, 'show'])->name('permissions.show');
            // 资源路由
            $api->resource('permissions', PermissionController::class);

            /**
             * 用户管理
             */
            // 用户 启用/禁用
            $api->patch('users/{user}/lock', [UserController::class, 'lock'])->name('users.lock');
            // 用户管理资源路由
            $api->resource('users', UserController::class, ['only' => [
                'index', 'show',
            ]]);

            /**
             * 分类管理
             */
            // 分类 启用/禁用
            $api->patch('categorys/{category}/status', [CategoryController::class, 'status'])->name('categorys.status');
            // 分类管理资源路由
            $api->resource('categorys', CategoryController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 品牌管理
             */
            // 启用/禁用
            $api->patch('brands/{brand}/status', [CategoryController::class, 'status'])->name('brands.status');
            // 资源路由
            $api->resource('brands', CategoryController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 商品管理
             */
            // 商品上架
            $api->patch('goods/{good}/on', [GoodsController::class, 'isOn'])->name('goods.on');
            // 推荐商品
            $api->patch('goods/{good}/recommend', [GoodsController::class, 'isRecommend'])->name('goods.recommend');
            // 商品管理资源路由
            $api->resource('goods', GoodsController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 评论管理
             */
            // 评价列表
            $api->get('comments', [CommentController::class, 'index'])->name('comments.index');
            // 评价详情
            $api->get('comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
            // 商家回复
            $api->patch('comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

            /**
             * 订单管理
             */
            // 订单列表
            $api->get('orders', [OrderController::class, 'index'])->name('orders.index');
            // 订单详情
            $api->get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            // 订单发货
            $api->patch('orders/{order}/post', [OrderController::class, 'post'])->name('orders.post');

            /**
             * 轮播图管理
             */
            // 状态
            $api->patch('slides/{slide}/status', [SlideController::class, 'status'])->name('slides.status');
            // 排序
            $api->patch('slides/{slide}/sort', [SlideController::class, 'sort'])->name('slides.sort');
            // 资源路由
            $api->resource('slides', SlideController::class);

            /**
             * 菜单管理
             */
            // 列表
            $api->get('menus', [MenuController::class, 'index'])->name('menus.index');

            // 刷新token
            $api->get('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
            // 阿里云OSS Token
            $api->get('oss-token', [OssController::class, 'token'])->name('auth.oss-token');
        });
    });

});
