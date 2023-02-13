<?php

namespace App\Providers;

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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\UserPasswordUpdateEvent' => [
            'App\Listeners\SendPasswordUpdateNotification',
        ],
        'App\Events\IssuesNotificationEvent' => [
            'App\Listeners\SendIssuesNotification',
        ],
        'App\Events\MemberProjectNotificationEvent' => [
            'App\Listeners\SendNewMemberProjectNotification',
        ],
        'App\Events\ApprovementFlowNotificationEvent' => [
            'App\Listeners\SendApprovementFlowNotificationEvent',
        ],
        'App\Events\SolicitacaoFundosNotificationEvent' => [
            'App\Listeners\SendSolicitacaoFundosNotification',
        ],
        // 'App\Events\ProjectActionEvent' => [
        //     'App\Listeners\SendProjectCreateNotification',
        //     'App\Listeners\SendProjectUpdateNotification',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
