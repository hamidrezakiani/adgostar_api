<?php

namespace App\Providers;

use App\Events\CategoryCreatedEvent;
use App\Events\ItemCreatedEvent;
use App\Events\OrderCreatedEvent;
use App\Events\ProductCreatedEvent;
use App\Events\SetCategoryParentEvent;
use App\Events\SetItemProductEvent;
use App\Events\SetProductCategoryEvent;
use App\Events\UnsetCategoryParentEvent;
use App\Events\UnsetItemProductEvent;
use App\Events\UnsetProductCategoryEvent;
use App\Events\UpdateItemPeriodEvent;
use App\Listeners\CreateFirstItemListener;
use App\Listeners\CreateFirstPeriodListener;
use App\Listeners\DecreaseCategoryCountProductListener;
use App\Listeners\DecreaseCategoryCountSubCatListener;
use App\Listeners\DecreaseProductItemListener;
use App\Listeners\IncreaseCategoryCountProductListener;
use App\Listeners\IncreaseCategoryCountSubCatListener;
use App\Listeners\IncreaseProductItemListener;
use App\Listeners\OrderPropertiesListener;
use App\Listeners\OrderTimesListener;
use App\Listeners\ResetRepresentationItemPeriodListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UpdateItemPeriodEvent::class => [
            ResetRepresentationItemPeriodListener::class,
        ],
        ItemCreatedEvent::class => [
            CreateFirstPeriodListener::class,
            IncreaseProductItemListener::class,
            ResetRepresentationItemPeriodListener::class,
        ],
        SetItemProductEvent::class => [
            IncreaseProductItemListener::class,
        ],
        UnsetItemProductEvent::class => [
            DecreaseProductItemListener::class,
        ],
        ProductCreatedEvent::class => [
            IncreaseCategoryCountProductListener::class,
            CreateFirstItemListener::class,
        ],
        UnsetProductCategoryEvent::class => [
            DecreaseCategoryCountProductListener::class,
        ],
        SetProductCategoryEvent::class => [
            IncreaseCategoryCountProductListener::class,
        ],
        CategoryCreatedEvent::class => [
            IncreaseCategoryCountSubCatListener::class,
        ],
        SetCategoryParentEvent::class => [
            IncreaseCategoryCountSubCatListener::class,
        ],
        UnsetCategoryParentEvent::class => [
            DecreaseCategoryCountSubCatListener::class,
        ],
        \App\Events\OrderCreatedEvent::class => [
           \App\Listeners\OrderTimesListener::class,
           \App\Listeners\OrderPropertiesListener::class,
        ],
        \App\Events\OrderPayedSuccess::class => [
            \App\Listeners\ExecuterProfitListener::class,
            \App\Listeners\RepresentationProfitListener::class,
        ],
        \App\Events\FastUserEvent::class => [
            \App\Listeners\SmsPasswordUserListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
