<?php

namespace App\Providers;

use App\Services\Lib\MyClientBuilder;
use Elastic\Client\ClientBuilderInterface;
use Elastic\Elasticsearch\ClientBuilder as ESClientBuilder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 注册一个名为 es 的单例
        $this->app->singleton('es', function () {
            // 从配置文件读取 Elasticsearch 服务器列表
            $builder = ESClientBuilder::create()
                ->setHosts(config('database.elasticsearch.hosts'))
                ->setBasicAuthentication(config('database.elasticsearch.username'), config('database.elasticsearch.password'));
            // 如果是开发环境
            if (app()->environment() === 'local') {
                // 配置日志，Elasticsearch 的请求和返回数据将打印到日志文件中，方便我们调试
                $builder->setLogger(app('log')->driver());
            }
            // 返回连接
            return $builder->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // 针对早期 mysql 数据迁移
    }
}
