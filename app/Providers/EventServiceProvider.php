<?php

namespace App\Providers;

use App\Models\Category;
use App\Observers\CategoryObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderPost;
use App\Listeners\SendEmailToOrderUser;
use App\Models\Slide;
use App\Observers\SlideObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderPost::class => [
            SendEmailToOrderUser::class,
        ],
        \App\Events\SendSms::class => [
            \App\Listeners\SendCodeForPreconditions::class, // 发送验证码的前提条件
            \App\Listeners\SendCodeToUser::class, // 发送短信验证码
        ],
        \App\Events\SendMailCode::class => [
            \App\Listeners\SendMailCodeForPreconditions::class, // 发送邮件验证码的前提条件
            \App\Listeners\SendMailCodeToUser::class, // 发送邮件验证码
        ],
        \App\Events\OrderSubmit::class => [
            \App\Listeners\OrderSubmitInTenMinutes::class, // 用户下单后，检测十分钟内是否已经支付，否则订单状态修改为 过期
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // 分类模型 - 观察者
        Category::observe(CategoryObserver::class);
        // Slide::observe(SlideObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
