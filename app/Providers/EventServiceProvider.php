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
