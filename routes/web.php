<?php

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\BrandController;
use App\Http\Controllers\Web\Admin\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// 上线后，需要注释
Route::get('/', function () {
    return view('welcome');
});

// swoole
Route::get('swoole/test', function () {
    return view('swoole/test');
});
Route::get('swoole/notify', function () {
    return view('swoole/notify');
});
Route::get('swoole/room', function () {
    return view('swoole/room');
});


// 路由前缀 路由名称前缀
Route::prefix('admin')->name('admin.')->group(function () {

    /************************ auth ************************/
    Route::prefix('auth')
        ->name('auth.')
        ->controller(AuthController::class)
        ->group(function () {
            // 登录
            Route::get('login', 'login')->name('login');
        });

    /************************ 主页 ************************/
    Route::prefix('home')
        ->name('home.')
        ->controller(HomeController::class)
        ->group(function () {
            // 首页
            Route::get('index', 'index')->name('index');
            // welcome
            Route::get('welcome', 'welcome')->name('welcome');
        });

    /************************ 分类列表 ************************/
    Route::prefix('categorys')
        ->name('categorys.')
        ->controller(HomeController::class)
        ->group(function () {
            // 列表
            Route::get('index', 'index')->name('index');
            // 添加
            Route::get('create', 'create')->name('create');
            // 修改
            Route::get('edit', 'edit')->name('edit');
        });

    /************************ 品牌列表 ************************/
    Route::prefix('brands')
        ->name('brands.')
        ->controller(BrandController::class)
        ->group(function () {
            // 列表
            Route::get('index', 'index')->name('index');
            // 添加
            Route::get('create', 'create')->name('create');
            // 修改
            Route::get('edit', 'edit')->name('edit');
        });

    /************************ 商品管理 ************************/
    Route::prefix('goods')
        ->name('goods.')
        ->controller(HomeController::class)
        ->group(function () {
            // 列表
            Route::get('index', 'index')->name('index');
            // 添加
            Route::get('create', 'create')->name('create');
            // 修改
            Route::get('edit', 'edit')->name('edit');
        });

    /************************ 商品类型 ************************/
    Route::prefix('goodsType')
        ->name('goodsType.')
        ->controller(HomeController::class)
        ->group(function () {
            // 列表
            Route::get('index', 'index')->name('index');
            // 添加
            Route::get('create', 'create')->name('create');
            // 修改
            Route::get('edit', 'edit')->name('edit');
        });

    /************************ 商品属性 ************************/
    Route::prefix('goodsAttr')
        ->name('goodsAttr.')
        ->controller(HomeController::class)
        ->group(function () {
            // 列表
            Route::get('index', 'index')->name('index');
            // 添加
            Route::get('create', 'create')->name('create');
            // 修改
            Route::get('edit', 'edit')->name('edit');
        });

    /************************ 商品规格 ************************/
    Route::prefix('goodsSpec')
        ->name('goodsSpec.')
        ->controller(HomeController::class)
        ->group(function () {
            // 列表
            Route::get('index', 'index')->name('index');
            // 添加
            Route::get('create', 'create')->name('create');
            // 修改
            Route::get('edit', 'edit')->name('edit');
        });
});
