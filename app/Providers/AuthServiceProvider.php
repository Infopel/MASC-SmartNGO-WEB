<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Issues' => 'App\Policies\IssuesPolicy',
        'App\Models\Projects' => 'App\Policies\ProjectsPolicy',
        'App\Models\Attachments' => 'App\Policies\AttachmentsPolicy',
        'App\Models\Budgets' => 'App\Policies\BudgetsPolicy',
        'App\Models\Documents' => 'App\Policies\DocumentsPolicy',
        'App\Models\Enumerations' => 'App\Policies\EnumerationsPolicy',
        'App\Models\Gantt' => 'App\Policies\GanttPolicy',
        'App\Models\IssueStatus' => 'App\Policies\IssueStatusPolicy',
        'App\Models\News' => 'App\Policies\NewsPolicy',
        'App\Models\Partners' => 'App\Policies\PartnersPolicy',
        'App\Models\Repositories' => 'App\Policies\RepositoriesPolicy',
        'App\Models\Trackers' => 'App\Policies\TrackersPolicy',
        'App\Models\TimeEntries' => 'App\Policies\TimeEntriesPolicy',
        'App\Models\Roles' => 'App\Policies\RolesPolicy',
        'App\Models\Wiki' => 'App\Policies\WikiPolicy',
        'App\Models\Trackers' => 'App\Policies\TrackersPolicy',
        'App\Models\FlowSolicitacaoFundos' => 'App\Policies\FlowSolicitacaoFundosPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
