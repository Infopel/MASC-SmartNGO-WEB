<?php

use App\Models\User;
use Illuminate\Mail\Markdown;
use App\Mail\NewUserNotification;

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

Route::get("register", function () {
    return "Error";
});

Auth::routes();

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
// Auth all routes
Route::group(['middleware' => ['auth:web'], 'prefix' => '/'], function () {
    // routa principal
    Route::get('/', 'AppController@show')->name('app.index');

    // Localization
    Route::get('/js/lang.js', function () {
        $strings = Cache::rememberForever('lang.js', function () {
            $lang = config('app.locale');

            $files   = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }

            return $strings;
        });

        header('Content-Type: text/javascript');
        echo ('window.i18n = ' . json_encode($strings) . ';');
        exit();
    })->name('assets.lang');

    /** Plano de Aprovacoes P2F */

    Route::get("workflow_p2f", 'ActivityPlanApprovementController@index')->name("workflow_p2f");
    Route::post("workflow_p2f/initialize", 'ActivityPlanApprovementController@initWorflowP2F')->name("workflow_p2f");

    /** / Plano de Aprovacoes P2F */

    /**Projectos */
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', 'ProjectsController@index')->name('app.projectos');
        Route::get('/{project_identifier}', 'ProjectsController@show')->name('projects.overview');

        /** Criar Novo Projecto */
        Route::get('/create/new', 'ProjectsController@create')->name('projects.new')->where('new', '==', 'new');
        Route::post('/create/new', 'ProjectsController@store')->name('projects.store');

        Route::get('/{project_identifier}/project_members', 'ProjectsController@project_members')->name('projects.members');

        // Project actions
        Route::get('/{project_identifier}/action/{action}', 'ProjectsController@request_action')->name('projects.request_action');
        Route::post('/{project_identifier}/action/{action}', 'ProjectsController@run_action')->name('projects.run_action');
        // end Actions routes


        Route::post('/{project_identifier}/update', 'ProjectsController@update')->name('projects.update');

        /** Dinamic routes */
        /** Activity routes */
        Route::get('{project_identifier}/activity', 'ActivitiesController@project')->name('projects.activity');
        Route::get('{project_identifier}/activity/{id_actividade}', 'ProjectsController@index')->name('projects.issue-atividade');


        Route::get('/{project_identifier}/issues/tracker/{tracker}', 'IssuesController@getIssues')->name('projects.issue_tracking_alt');

        Route::get('/{project_identifier}/issues/report', 'IssuesController@reportIssue')->name('projects.issue_report');
        Route::get('/{project_identifier}/issues/import', 'IssuesController@importIssue')->name('projects.issue_import');
        Route::get('/{project_identifier}/issues/export', 'IssuesController@exportIssue')->name('projects.issue_export');


        // Route::get('/{project_identifier}/documents/', 'DocumentsController@project_documents')->name('projects.documents');

        /**
         * Project Issues
         */
        Route::group(['prefix' => '/{project_identifier}/issues/'], function () {
            Route::get('/', 'IssuesController@index')->name('projects.issues.tracking');

            Route::get('/new', 'IssuesController@create')->name('projects.issues.new');
            Route::post('/new', 'IssuesController@store')->name('projects.issues.store');
        });


        /**
         * Arquivos
         */
        Route::group(['prefix' => '/{project_identifier}/documents/'], function () {

            Route::get('/', 'DocumentsController@project_documents')->name('projects.documents');
            Route::get('/create', 'DocumentsController@create')->name('document.create');
            Route::post('/create', 'DocumentsController@store')->name('document.store');
            Route::get('/edit/{document}', 'DocumentsController@edit')->name('document.edit');
            Route::post('/edit/{document}', 'DocumentsController@update')->name('document.update');

            Route::post('/remove-confirmation/{document}', 'DocumentsController@remove_request')->name('document.remove-request');
            Route::post('/remove/{document}', 'DocumentsController@destroy')->name('document.remove');
        });

        Route::get('/{project_identifier}/files/', 'DocumentsController@project_documents')->name('projects.files');

        // Gantt Routes
        Route::get('/{project_identifier}/gantt/', 'GanntController@show')->name('projects.gantt');

        /**
         * Wiki
         */
        Route::get('/{project_identifier}/wiki/', 'WikisController@index')->name('projects.wiki');


        Route::get('/{project_identifier}/news/', 'NewsController@project_news')->name('projects.news');
        Route::get('/{project_identifier}/news/{news}', 'NewsController@show_project_news')->name('projects.news.show')->where('news', '[0-9]+');
        Route::get('/{project_identifier}/news/new', 'NewsController@create')->name('project.new-news');
        Route::post('/{project_identifier}/news/new', 'NewsController@store')->name('project.new-store');

        Route::get('/{project_identifier}/calendar/', 'CalendarController@show')->name('projects.calendar');


        Route::get('/{project_identifier}/time_entries/', 'TimeEntriesController@index')->name('projects.time_entries');
        Route::get('/{project_identifier}/time_tracking/', 'TimeEntriesController@index')->name('projects.time_tracking');
        Route::get('/{project_identifier}/boards/', 'DocumentsController@project_documents')->name('projects.boards');
        Route::get('/{project_identifier}/tab/', 'DocumentsController@project_documents')->name('projects.tab');
        Route::get('/{project_identifier}/repository/', 'DocumentsController@project_documents')->name('projects.repository');
        Route::get('/{project_identifier}/report_filters/', 'DocumentsController@project_documents')->name('projects.report_filters');


        Route::group(['prefix' => '/{project_identifier}/settings/'], function () {
            Route::get('/', 'ProjectsSettiginsController@index')->name('projects.settings');

            Route::post('/update/modules', 'ProjectsSettiginsController@update_modules')->name('projects.update-modules');
            Route::post('/trackers', 'ProjectsSettiginsController@project_tracker')->name('projects.project_tracker');
        });

        Route::get('/{project_identifier}/custom_reports/', 'SettingsController@project')->name('projects.custom_reports');
        // Orcamento

        // Route::get('/{project_identifier}/orcamento/', 'BudgetController@index')->name('projects.finance');

        /** Financas */
        Route::group(['prefix' => '/{project_identifier}/orcamento', 'as' => 'orcamento.projecto.'], function () {
            // Route::livewire('/', "OrcamentoProjectoController@index")->layout('layouts.main', ['title' => 'Relatorios'])->name('index');
            Route::get('/', "OrcamentoProjectoController@index")->name('index');
            Route::post('/import-rubricas-orcamento', "OrcamentoProjectoController@import_rubricas_orcamento")->name('import-rubricas-orcamento');

            Route::post('solicitacao-fundos/issue/{issue}/init/request', "OrcamentoProjectoController@solicitacao_issue_init_request")
                ->name('solicitacao-fundos.issue_init_request');

            Route::get('solicitacao-fundos/', "OrcamentoProjectoController@solicitacao_index")->name('solicitacao-fundos');


            Route::get('solicitacao-fundos/{issue}', "OrcamentoProjectoController@solicitacao_show")->name('solicitacao-fundos.show');

            Route::post('solicitacao-fundos/validation/{issue}/{approvement}', "OrcamentoProjectoController@solicitacao_validation")
                ->name('solicitacao.validation');

            // Route::post('solicitacao-fundos/validation/{issue}', "OrcamentoProjectoController@solicitacao_validation")->name('solicitacao.validation');


            Route::post('solicitacao-fundos/re_validation/{issue}/{approvement}', "OrcamentoProjectoController@re_validation")
                ->name('solicitacao.re_validation');

            Route::post('solicitacao-fundos/reprovar/{issue}/{approvement}', "OrcamentoProjectoController@solicitacao_reprovar")
                ->name('solicitacao.reprovar');


            // Novo Modelo de solicitacao de fundos
            Route::get('formulario-solicitacao-fundos/', 'SolicitacaoFundosController@form')->name('form_solicitacao_fundos');
            Route::get('formulario-solicitacao-fundos/editar/{requestNum}', 'SolicitacaoFundosController@editForm')->name('form_edit_solicitacao_fundos');

            Route::post('formulario-solicitacao-fundos/editar/{requestNum}', 'SolicitacaoFundosController@updateRequisicao')->name('form_edit_solicitacao_fundos');

            Route::post('formulario-solicitacao-fundos/', 'SolicitacaoFundosController@store')->name('form_solicitacao_fundos');

            Route::get('new/solicitacao-fundos/', 'SolicitacaoFundosController@index')->name('solicitacao_fundos');

            Route::get('new/solicitacao-fundos/requisicao/{requestNum}', 'SolicitacaoFundosController@showDetailsBugetApprovementFlow')
                ->name('details-solicitacao_fundos');

            Route::post('new/solicitacao-fundos/requisicao/{requestNum}/validation/{approvementFlow}', "SolicitacaoFundosController@solicitacao_validation")
                ->name('solicitacao_fundos.validation');


            Route::post('solicitacao-fundos/reprovar/requisicao/{requestNum}/{approvementFlow}', 'SolicitacaoFundosController@solicitacao_reprovar')
                ->name('solicitacao_fundos.reprovarStep');

            Route::post('solicitacao-fundos/re_validation/requisicao/{requestNum}/{approvementFlow}', 'SolicitacaoFundosController@solicitacao_re_validation')
                ->name('solicitacao_fundos.requestApprovalAgain');

            Route::get('formulario/pagamento', 'SolicitacaoFundosController@form_pagamento')->name('solicitacao_fundos_form_pagamento');


            // Outputs do processo de solicitacao de fundos
            Route::get('outputs/solicitacao-fundos/requisicao/{requestNum}/{requestID}', 'SolicitacaoFundosController@outputs')->name('outputs');
        });


        Route::get('/{project_identifier}/budget', 'BudgetController@index')->name('projects.budget');
        Route::get('/{project_identifier}/budget/new', 'BudgetController@create')->name('projects.budget.new');
        Route::get('/{project_identifier}/budget/edit', 'BudgetController@index')->name('projects.budget.edit');
        Route::get('/{project_identifier}/budget/config', 'BudgetController@index')->name('projects.budget.config');
    });


    /**TimeSheet*/
    Route::group(['prefix' => 'timesheets'], function () {
        Route::get('/', 'TimeSheetController@index')->name('app.timesheets');
        Route::get('/approve', 'TimeSheetController@mount')->name('app.timesheets_approve');
        Route::post('/approved', 'TsActivitiesController@mount')->name('app.approve_timesheet');
        Route::get('/{ts_activite}/flow', 'TsActivitiesController@history_flow')->name('app.flow_approve_timesheet')->where('ts_activite', '[0-9]+');
        Route::post('/flow_timesheet', 'TsActivitiesController@flow_approvement')->name('app.flow_approvement');
        //Route::get('/{project_identifier}', 'ProjectsController@show')->name('projects.overview');

        /** Criar Nova TimeSheet */
        Route::get('/create/new', 'TimeSheetController@create')->name('timesheets.new')->where('new', '==', 'new');
        Route::post('/create/new', 'TimeSheetController@store')->name('timesheets.store');

        /**
         * Project Issues
         */
        Route::group(['prefix' => 'ts_activities/'], function () {
            Route::get('/', 'TsActivitiesController@index')->name('timesheets.activity.index');
            Route::get('/new', 'TsActivitiesController@create')->name('timesheets.activity.new');
            Route::post('/new', 'TsActivitiesController@store')->name('timesheets.activity.store');
        });


        // /**
        //  * Arquivos
        //  */
        // Route::group(['prefix' => '/{project_identifier}/documents/'], function () {

        //     Route::get('/', 'DocumentsController@project_documents')->name('projects.documents');
        //     Route::get('/create', 'DocumentsController@create')->name('document.create');
        //     Route::post('/create', 'DocumentsController@store')->name('document.store');
        //     Route::get('/edit/{document}', 'DocumentsController@edit')->name('document.edit');
        //     Route::post('/edit/{document}', 'DocumentsController@update')->name('document.update');

        //     Route::post('/remove-confirmation/{document}', 'DocumentsController@remove_request')->name('document.remove-request');
        //     Route::post('/remove/{document}', 'DocumentsController@destroy')->name('document.remove');
        // });

        // Route::get('/{project_identifier}/files/', 'DocumentsController@project_documents')->name('projects.files');

        // // Gantt Routes
        // Route::get('/{project_identifier}/gantt/', 'GanntController@show')->name('projects.gantt');

        // /**
        //  * Wiki
        //  */
        // Route::get('/{project_identifier}/wiki/', 'WikisController@index')->name('projects.wiki');


        // Route::get('/{project_identifier}/news/', 'NewsController@project_news')->name('projects.news');
        // Route::get('/{project_identifier}/news/{news}', 'NewsController@show_project_news')->name('projects.news.show')->where('news', '[0-9]+');
        // Route::get('/{project_identifier}/news/new', 'NewsController@create')->name('project.new-news');
        // Route::post('/{project_identifier}/news/new', 'NewsController@store')->name('project.new-store');

        // Route::get('/{project_identifier}/calendar/', 'CalendarController@show')->name('projects.calendar');


        // Route::get('/{project_identifier}/time_entries/', 'TimeEntriesController@index')->name('projects.time_entries');
        // Route::get('/{project_identifier}/time_tracking/', 'TimeEntriesController@index')->name('projects.time_tracking');
        // Route::get('/{project_identifier}/boards/', 'DocumentsController@project_documents')->name('projects.boards');
        // Route::get('/{project_identifier}/tab/', 'DocumentsController@project_documents')->name('projects.tab');
        // Route::get('/{project_identifier}/repository/', 'DocumentsController@project_documents')->name('projects.repository');
        // Route::get('/{project_identifier}/report_filters/', 'DocumentsController@project_documents')->name('projects.report_filters');


        // Route::group(['prefix' => '/{project_identifier}/settings/'], function () {
        //     Route::get('/', 'ProjectsSettiginsController@index')->name('projects.settings');

        //     Route::post('/update/modules', 'ProjectsSettiginsController@update_modules')->name('projects.update-modules');
        //     Route::post('/trackers', 'ProjectsSettiginsController@project_tracker')->name('projects.project_tracker');
        // });

        // Route::get('/{project_identifier}/custom_reports/', 'SettingsController@project')->name('projects.custom_reports');
        // // Orcamento

        // // Route::get('/{project_identifier}/orcamento/', 'BudgetController@index')->name('projects.finance');

        // /** Financas */
        // Route::group(['prefix' => '/{project_identifier}/orcamento', 'as' => 'orcamento.projecto.'], function () {
        //     // Route::livewire('/', "OrcamentoProjectoController@index")->layout('layouts.main', ['title' => 'Relatorios'])->name('index');
        //     Route::get('/', "OrcamentoProjectoController@index")->name('index');
        //     Route::post('/import-rubricas-orcamento', "OrcamentoProjectoController@import_rubricas_orcamento")->name('import-rubricas-orcamento');

        //     Route::post('solicitacao-fundos/issue/{issue}/init/request', "OrcamentoProjectoController@solicitacao_issue_init_request")
        //         ->name('solicitacao-fundos.issue_init_request');

        //     Route::get('solicitacao-fundos/', "OrcamentoProjectoController@solicitacao_index")->name('solicitacao-fundos');


        //     Route::get('solicitacao-fundos/{issue}', "OrcamentoProjectoController@solicitacao_show")->name('solicitacao-fundos.show');

        //     Route::post('solicitacao-fundos/validation/{issue}/{approvement}', "OrcamentoProjectoController@solicitacao_validation")
        //         ->name('solicitacao.validation');

        //     // Route::post('solicitacao-fundos/validation/{issue}', "OrcamentoProjectoController@solicitacao_validation")->name('solicitacao.validation');


        //     Route::post('solicitacao-fundos/re_validation/{issue}/{approvement}', "OrcamentoProjectoController@re_validation")
        //         ->name('solicitacao.re_validation');

        //     Route::post('solicitacao-fundos/reprovar/{issue}/{approvement}', "OrcamentoProjectoController@solicitacao_reprovar")
        //         ->name('solicitacao.reprovar');


        //     // Novo Modelo de solicitacao de fundos
        //     Route::get('formulario-solicitacao-fundos/', 'SolicitacaoFundosController@form')->name('form_solicitacao_fundos');
        //     Route::get('formulario-solicitacao-fundos/editar/{requestNum}', 'SolicitacaoFundosController@editForm')->name('form_edit_solicitacao_fundos');

        //     Route::post('formulario-solicitacao-fundos/editar/{requestNum}', 'SolicitacaoFundosController@updateRequisicao')->name('form_edit_solicitacao_fundos');

        //     Route::post('formulario-solicitacao-fundos/', 'SolicitacaoFundosController@store')->name('form_solicitacao_fundos');

        //     Route::get('new/solicitacao-fundos/', 'SolicitacaoFundosController@index')->name('solicitacao_fundos');

        //     Route::get('new/solicitacao-fundos/requisicao/{requestNum}', 'SolicitacaoFundosController@showDetailsBugetApprovementFlow')
        //         ->name('details-solicitacao_fundos');

        //     Route::post('new/solicitacao-fundos/requisicao/{requestNum}/validation/{approvementFlow}', "SolicitacaoFundosController@solicitacao_validation")
        //         ->name('solicitacao_fundos.validation');


        //     Route::post('solicitacao-fundos/reprovar/requisicao/{requestNum}/{approvementFlow}', 'SolicitacaoFundosController@solicitacao_reprovar')
        //         ->name('solicitacao_fundos.reprovarStep');

        //     Route::post('solicitacao-fundos/re_validation/requisicao/{requestNum}/{approvementFlow}', 'SolicitacaoFundosController@solicitacao_re_validation')
        //         ->name('solicitacao_fundos.requestApprovalAgain');

        //     Route::get('formulario/pagamento', 'SolicitacaoFundosController@form_pagamento')->name('solicitacao_fundos_form_pagamento');


        //     // Outputs do processo de solicitacao de fundos
        //     Route::get('outputs/solicitacao-fundos/requisicao/{requestNum}/{requestID}', 'SolicitacaoFundosController@outputs')->name('outputs');
        // });


        // Route::get('/{project_identifier}/budget', 'BudgetController@index')->name('projects.budget');
        // Route::get('/{project_identifier}/budget/new', 'BudgetController@create')->name('projects.budget.new');
        // Route::get('/{project_identifier}/budget/edit', 'BudgetController@index')->name('projects.budget.edit');
        // Route::get('/{project_identifier}/budget/config', 'BudgetController@index')->name('projects.budget.config');
    });

    /**
     * PDES
     */
    Route::group(['prefix' => 'projects/pde'], function () {
        /** Criar Novo PDE */

        Route::get('/edit/{project}', 'PDEController@edit')->name('pde.edit');
        Route::post('/edit/{project}', 'PDEController@update')->name('pde.edit');
        Route::get('/create/new', 'PDEController@create')->name('pde.new')->where('new', '==', 'new');
        Route::post('/create/new', 'PDEController@store')->name('pde.store');
    });

    /**
     * Route para programs
     */
    Route::group(['prefix' => 'programs'], function () {
        Route::get('/', 'ProgramsController@index')->name('programs.index');
        Route::get('/{program}', 'ProgramsController@show')->name('programs.show');

        Route::get('/create/new', 'ProgramsController@create')->name('programs.create');
        Route::get('/create/new/related_to/{indentifier}', 'ProgramsController@create_related_to')->name('programs.pde.create');

        Route::post('/create/new', 'ProgramsController@store')->name('programs.create');
        Route::get('/edit/{program}', 'ProgramsController@edit')->name('programs.edit');
        Route::post('/edit/{program}', 'ProgramsController@update')->name('programs.update');

        Route::get('/{program}/projects/{project_identifier}', 'ProgramsController@listProjects')->name('programs.projects');
        Route::get('/remove/{program}', 'ProgramsController@remove_confirmation')->name('programs.delete-request');
        Route::post('/remove/{program}', 'ProgramsController@destroy')->name('programs.remove');
    });

    // activity
    Route::group(['prefix' => 'activity'], function () {
        Route::get('/', 'ActivitiesController@index')->name('activity.index');
    });

    /** Issues */
    Route::group(['prefix' => 'issues'], function () {
        Route::get('/', 'IssuesController@issues')->name('issues.index');
        Route::get('/{issue}', 'IssuesController@show')->name('issues.show')->where('issue', '[0-9]+');
        Route::get('/{issue}/edit', 'IssuesController@edit')->name('issues.edit')->where('issue', '[0-9]+');
        Route::post('/{issue}/edit', 'IssuesController@update')->name('issues.update')->where('issue', '[0-9]+');

        Route::post('watchars/{watchable_id}/{watchable_type}', 'IssuesController@self_watcher')->name('issue.self_watcher');

        Route::get('/remove/{issue}', 'IssuesController@delete_request')->name('issue.delete-request');
        Route::post('/remove/{issue}', 'IssuesController@destroy')->name('issue.remove');

        /**
         * Aprovar e reprovar Tarefas
         */
        Route::post('/{issue}/report/actioin/{action}', 'IssuesController@reportActioin')->name('issue.report');

        /** Issues time tracking */
        Route::get('/{issue}/time_entries', 'TimeEntriesController@show_issue')->name('time_entries.issues');
        Route::get('/{issue}/time_entries/show/{indicator}', 'TimeEntriesController@show')->name('time_entries.issues.show');
        Route::get('/{issue}/time_entries/new', 'TimeEntriesController@create')->name('time_entries.issues.new');
        Route::post('/{issue}/time_entries/new', 'TimeEntriesController@store')->name('time_entries.issues.store');
        Route::get('/{issue}/time_entries/{time_entrie}/edit', 'TimeEntriesController@edit')->name('time_entries.issues.edit');
        Route::post('/{issue}/time_entries/{time_entrie}/edit', 'TimeEntriesController@update')->name('time_entries.issues.update');

        Route::get('/{issue}/time_entries/remove/request/{time_entries_values}', 'TimeEntriesController@remove_time_entrie_values_permission')
            ->name('time_entries.issues.remove_request');

        Route::post('/time_entries/remove/request/{time_entries_values}', 'TimeEntriesController@remove_time_entrie_values')
            ->name('time_entries.issues.remove');

        Route::post('{issue}/time_entries/{time_entrie}/request/approve/', 'TimeEntriesController@request_report_approvement')
            ->name('time_entries.request.approve');

        Route::post('{issue}/time_entries/{time_entrie}/request/{flowReportTask}/approve-validation', 'TimeEntriesController@validar_aprovacao_realizado')
            ->name('time_entries.request.approve_validation');

        /** Budgetize Issues */
        Route::get('/{issue}/budget', 'BudgetController@issue_budget')->name('issues.budget');
        Route::get('/{issue}/budget/new', 'BudgetController@issue_new_budget')->name('issues.budget.new');

        Route::get('/{issue}/budget/edit/{budget}', 'BudgetController@issue_edit_budget')->name('issues.budget.edit');
        Route::post('/{issue}/budget/edit/{budget}', 'BudgetsValuesController@update')->name('issues.budget.update');

        Route::get('/time_entries/new', 'TimeEntriesController@create')->name('time_entries.new');
        Route::post('/time_entries/new', 'TimeEntriesController@store')->name('time_entries.store');

        Route::post('/{issue}/request/flow-approve/{approvement}', 'IssuesController@IssueFlowApproveRequest')->name('IssueFlowApproveRequest.request');
        Route::post('/{issue}/request/flow-unapprove/{approvement}', 'IssuesController@IssueFlowUnApproveRequest')->name('IssueFlowUnApproveRequest.request');
    });

    // Gantt
    Route::get('/gantt', 'GanntController@index')->name('gantt.index');
    // Gantt data
    Route::get('/gantt/data-blobal', 'GanntController@gantt_main_global')->name('gantt.data-global');

    Route::get('/issues/gantt', 'GanntController@index')->name('gantt.issues');
    Route::get('/{project_identifier}/gant', 'GanntController@show')->name('gant.projects');

    Route::get('projects/{project_identifier}/gantt/data', 'GanntController@show_project_data')->name('gant.projects.data');

    // time_entries
    Route::group(['prefix' => 'time_entries'], function () {
        Route::get('/', 'TimeEntriesController@index')->name('time_entries.index');

        Route::get('/remove/request/{time_entry}', 'TimeEntriesController@remove_permission')->name('time_entries.remove_request');
        Route::post('/remove/{time_entry}', 'TimeEntriesController@destroy')->name('time_entries.remove');
    });
    // Calendar
    Route::group(['prefix' => 'calendar'], function () {
        Route::get('/', 'CalendarController@index')->name('calendar.index');
    });
    // News
    Route::group(['prefix' => 'news'], function () {
        Route::get('/', 'NewsController@index')->name('news.index');
        Route::get('/{news}', 'NewsController@show')->name('news.show')->where('news', '[0-9]+');
        Route::get('/create', 'NewsController@create')->name('news.create');
        Route::post('/create', 'NewsController@store')->name('news.store');
        Route::get('/edit/{news}', 'NewsController@edit')->name('news.edit')->where('news', '[0-9]+');
        Route::post('/edit/{news}', 'NewsController@update')->name('news.update')->where('news', '[0-9]+');
    });

    /** Documents */
    Route::group(['prefix' => 'documents'], function () {
        Route::get('/{document}', 'DocumentsController@show')->name('documents.show');
        Route::get('/{attachment}/{filename}', 'AttachmentsController@showAttach')->name('document.getDocument');
        // Route::get('download/{attachment}/{filename}', 'AttachmentsController@download')->name('document.download');
    });

    /** Documents */
    Route::group(['prefix' => 'attachments'], function () {
        // Route::get('/{id}', 'AttachmentsController@show')->name('attachments.show');
        Route::get('/{attachment}/{filename}', 'AttachmentsController@showAttach')->name('attachments.getDocument');
        Route::get('download/{attachment}/{filename}', 'AttachmentsController@download')->name('attachments.download');
    });

    /** Orcamento */
    Route::group(['prefix' => 'budget'], function () {
        Route::post('create', 'BudgetsValuesController@store')->name('budget.store');

        Route::group(['prefix' => 'config'], function () {
            Route::get('/', 'BudgetConfigController@index')->name('budget.config.index');
            Route::get('/valores-base', 'BudgetTrackerDefaultValuesController@create')->name('budget.config.valor_base');
            Route::get('/valores-base/edit/{default_value}', 'BudgetTrackerDefaultValuesController@edit')->name('budget.config.valor_base.edit');
            Route::post('/valores-base/edit/{default_value}', 'BudgetTrackerDefaultValuesController@update')->name('budget.config.valor_base.update');
            Route::post('/valores-base', 'BudgetTrackerDefaultValuesController@store')->name('budget.config.store_valor_base');

            Route::get('/tracker/edit/{budgetTracker}', 'BudgetTrackersController@edit')->name('budget.config.tracker_edit');
            Route::post('/tracker/edit/{budgetTracker}', 'BudgetTrackersController@update')->name('budget.config.tracker_update');
            Route::get('/tracker/create', 'BudgetTrackersController@create')->name('budget.config.tracker_new');
            Route::post('/tracker/create', 'BudgetTrackersController@store')->name('budget.config.tipo.store');

            Route::get('/tracker/remove/{budgetTracker}', 'BudgetTrackersController@remove_confirmation')->name('budget.config.tracker_remove_confirmation');
            Route::post('/tracker/remove/{budgetTracker}', 'BudgetTrackersController@destroy')->name('budget.config.tipo.destroy');

            /*** Add Budget Custom Fields */

            Route::get('budget/custom_field/create', 'BudgetCustomFieldsController@create')->name('budget.config.cf_new');
            Route::post('budget/custom_field/create', 'BudgetCustomFieldsController@store')->name('budget.config.cf_store');
            Route::get('budget/custom_field/remove_confirmation', 'BudgetCustomFieldsController@index')->name('budget.config.cf_remove_confirmation');
            Route::get('budget/custom_field/destroy', 'BudgetCustomFieldsController@index')->name('budget.config.cf_destroy');
        });
    });

    /** User page */
    Route::group(['prefix' => 'minha'], function () {
        Route::get('pagina/{user}', 'AccountController@show')->name('app.userPage');
        Route::get('conta/', 'UserController@minha_conta')->name('app.minha-conta');
        Route::get('conta/senha', 'UserController@minha_conta_senha')->name('app.minha-conta_senha');

        Route::post('conta/senha', 'UserController@update_auth_pass')->name('user.minha-update_senha');
    });

    /** Administration */
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'AppController@index')->name('admin.index');
        Route::get('/projects', 'AdministrationController@projects')->name('admin.projects');
        Route::get('/info', 'AdministrationController@info')->name('admin.info');
    });

    /** Users */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users.index');
        Route::get('/{user}', 'UserController@show')->name('users.show')->where('user', '[0-9]+');
        Route::get('/edit/{user}', 'UserController@edit')->name('users.edit');

        Route::post('/edit/{user}', 'UserController@update')->name('users.update');

        Route::post('/edit/groups/{user}', 'UserController@updateGroups')->name('users.updateGroups');

        Route::get('/new', 'UserController@create')->name('users.new');
        Route::post('/new', 'UserController@store')->name('users.store');

        Route::post('/activate/{user}', 'UserController@activateUser')->name('users.activate');
        Route::post('/lock/{user}', 'UserController@lookUser')->name('users.lock');
        Route::post('/unlock/{user}', 'UserController@unlockUser')->name('users.unlock');
        Route::get('/remove/{user}', 'UserController@delete_request')->name('users.delete-request');
        Route::post('/remove/{user}', 'UserController@destroy')->name('users.remove');

        Route::post('update/senha/{user}', 'UserController@admin_update_user_auth_pass')->name('user.update_senha');
    });

    /** groups */
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', 'GroupsController@index')->name('groups.index');
        Route::get('/edit/{group}', 'GroupsController@edit')->name('groups.edit');
        Route::post('/edit/{group}', 'GroupsController@update')->name('groups.update');
        Route::post('/edit/groups/{group}', 'GroupsController@updateGroups')->name('groups.updateGroups');
        Route::get('/new', 'GroupsController@create')->name('groups.new');
        Route::post('/new', 'GroupsController@store')->name('groups.store');
        Route::post('/delete/{group}', 'GroupsController@destroy')->name('groups.remove');

        Route::post('{group}/add-users', 'GroupsController@addUsers')->name('groups.add-users');
    });

    /**
     * Groups and Permissions - Global Permissions
     */
    Route::group(['prefix' => 'global-roles', 'middleware' => 'admin', 'as' => 'global_roles.'], function () {
        Route::get('/', 'GlobalRolesController@index')->name('index');
        Route::get('/new', 'GlobalRolesController@create')->name('create');
        Route::get('/edit/{role}', 'GlobalRolesController@edit')->name('create');
        Route::post('/edit/{role}', 'GlobalRolesController@update')->name('store');
        Route::get('/delete/{role}', 'GlobalRolesController@destroy')->name('destroy');
        // Route::get('')
    });


    /** groups */
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RolesController@index')->name('roles.index');
        Route::get('/edit/{role}', 'RolesController@edit')->name('roles.edit');
        Route::post('/edit/{role}', 'RolesController@update')->name('roles.update');
        // Route::post('/edit/role/{role}', 'RolesController@updateRole')->name('roles.updateRole');
        Route::get('/new', 'RolesController@create')->name('roles.new');
        Route::post('/new', 'RolesController@store')->name('roles.store');
        Route::get('/remove/{role}', 'RolesController@remove_permission')->name('roles.remove_permission');
        Route::post('/delete/{role}', 'RolesController@destroy')->name('roles.remove');
    });

    /** Tracker */
    Route::group(['prefix' => 'tracker'], function () {
        Route::get('/', 'TrackersController@index')->name('tracker.index');
        Route::get('/edit/{tracker}', 'TrackersController@edit')->name('tracker.edit');
        Route::post('/edit/{tracker}', 'TrackersController@update')->name('tracker.update');
        Route::get('/new', 'TrackersController@create')->name('tracker.new');
        Route::post('/new', 'TrackersController@store')->name('tracker.store');
        Route::get('remove/confirmation/{tracker}', 'TrackersController@remove_confirmation')->name('tracker.remove-request');
        Route::post('/delete/{tracker}', 'TrackersController@destroy')->name('tracker.remove');
    });

    /** issue_statuses */
    Route::group(['prefix' => 'issue_statuses'], function () {
        Route::get('/', 'IssueStatusesController@index')->name('issue_statuses.index');
        Route::get('/edit/{id}', 'IssueStatusesController@edit')->name('issue_statuses.edit');
        Route::post('/edit/{id}', 'IssueStatusesController@update')->name('issue_statuses.update');
        Route::get('/new', 'IssueStatusesController@create')->name('issue_statuses.new');
        Route::post('/new', 'IssueStatusesController@store')->name('issue_statuses.store');
        Route::post('/delete/{id}', 'IssueStatusesController@destroy')->name('issue_statuses.remove');
    });

    /** workflows */
    Route::group(['prefix' => 'workflows'], function () {
        Route::get('/', 'WorkflowsController@index')->name('workflows.index');
        Route::get('/edit', 'WorkflowsController@edit')->name('workflows.edit');
        Route::post('/edit/{id}', 'WorkflowsController@update')->name('workflows.update');
        Route::get('/new', 'WorkflowsController@create')->name('workflows.new');
        Route::post('/new', 'WorkflowsController@store')->name('workflows.store');
        Route::post('/delete/{id}', 'WorkflowsController@destroy')->name('workflows.remove');
    });

    Route::group(['prefix' => 'approvement_flows', 'as' => 'approvement_flows.'], function () {
        Route::livewire('/', 'approvement-flow')->layout('layouts.main', ['title' => 'Fluxo de Aprovação'])->name('index');
    });

    /** Custom fields */
    Route::group(['prefix' => 'custom_fields'], function () {
        Route::get('/', 'CustomFieldsController@index')->name('custom_fields.index');
        Route::get('/edit/{custom_field}', 'CustomFieldsController@edit')->name('custom_fields.edit');
        Route::post('/edit/{custom_field}', 'CustomFieldsController@update')->name('custom_fields.update');
        Route::get('/new', 'CustomFieldsController@create')->name('custom_fields.new');
        Route::post('/new', 'CustomFieldsController@store')->name('custom_fields.store');
        Route::get('/delete/{custom_field}', 'CustomFieldsController@delete_request')->name('custom_fields.delete_request');
        Route::post('/delete/{custom_field}', 'CustomFieldsController@destroy')->name('custom_fields.remove');
    });

    /** enumerations */
    Route::group(['prefix' => 'enumerations'], function () {
        Route::get('/', 'EnumerationsController@index')->name('enumerations.index');
        Route::get('/edit/{enumeration}', 'EnumerationsController@edit')->name('enumerations.edit');
        Route::post('/edit/{enumeration}', 'EnumerationsController@update')->name('enumerations.update');
        Route::get('/new', 'EnumerationsController@create')->name('enumerations.new');
        Route::post('/new', 'EnumerationsController@store')->name('enumerations.store');
        Route::get('remove/confirmation/{enumeration}', 'EnumerationsController@remove_permission')->name('enumerations.remove-request');
        Route::post('/delete/{enumeration}', 'EnumerationsController@destroy')->name('enumerations.remove');
    });

    /** Settings */
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::get('/edit', 'SettingsController@edit')->name('settings.edit');
        Route::post('/edit/{id}', 'SettingsController@update')->name('settings.update');
        Route::get('/new', 'SettingsController@create')->name('settings.new');
        Route::post('/new', 'SettingsController@store')->name('settings.store');
    });

    /** Partnenrs */
    Route::group(['prefix' => 'partners'], function () {
        Route::get('/', 'PartnersController@index')->name('partners.index');
        Route::get('/{partner}', 'PartnersController@show')->name('partners.show')->where('partner', '[0-9]+');

        Route::get('/{partner}/survey/{partnerAssessment}', 'PartnersController@survey')->name('partners.survey')->where('partner', '[0-9]+');
        Route::post('/{partner}/survey/{partnerAssessment}', 'PartnersController@surveyStore')->name('partners.survey_Store')->where('partner', '[0-9]+');

        Route::get('/edit/{partner}', 'PartnersController@edit')->name('partners.edit');
        Route::post('/edit/{partner}', 'PartnersController@update')->name('partners.update');
        Route::get('/new', 'PartnersController@create')->name('partners.new');
        Route::post('/new', 'PartnersController@store')->name('partners.store');

        Route::get('remove/confirmation/{partner}', 'PartnersController@remove_confirmation')->name('partners.remove_confirmation');
        Route::post('/remove/{partner}', 'PartnersController@destroy')->name('partners.remove');
    });

    /** questionnaire */
    Route::group(['prefix' => 'questionnaire_category'], function () {
        Route::get('/', 'QuestionnaireCategoriesController@index')->name('questionnaire.models.index');
        Route::get('/{questionnaireCategory}', 'QuestionnaireCategoriesController@show')->name('questionnaire.show')->where('questionnaireCategory', '[0-9]+');
        Route::get('/edit/{questionnaireCategory}', 'QuestionnaireCategoriesController@edit')->name('questionnaire.edit');
        Route::post('/edit/{questionnaireCategory}', 'QuestionnaireCategoriesController@update')->name('questionnaire.update');
        Route::get('/new', 'QuestionnaireCategoriesController@create')->name('questionnaire.create');
        Route::post('/new', 'QuestionnaireCategoriesController@store')->name('questionnaire.store');

        // Request para remover
        Route::get('/{questionnaireCategory}/remove/request', 'QuestionnaireCategoriesController@remvoe_request')
            ->name('questionnaire.remvoe_request')->where('questionnaireCategory', '[0-9]+');
        // Remover Categoria e suas perguntas
        Route::post('/{questionnaireCategory}/remove/request', 'QuestionnaireCategoriesController@destroy')
            ->name('questionnaire.destroy')->where('questionnaireCategory', '[0-9]+');


        Route::group(['prefix' => '{questionnaireCategory}/questions'], function () {
            Route::get('/', 'QuestionsController@index')->name('questions.index');
            Route::get('/{question}/edit', 'QuestionsController@edit')->name('questions.edit');
            Route::post('/{question}/edit', 'QuestionsController@update')->name('questions.update');
            Route::get('/new', 'QuestionsController@create')->name('questions.create');
            Route::post('/new', 'QuestionsController@store')->name('questions.store');

            Route::get('/{question}/remove/request', 'QuestionsController@remvoe_request')->name('questions.remvoe_request');
            Route::post('/{question}/remove', 'QuestionsController@destroy')->name('questions.destroy');
        });

        Route::get('/form/new', 'QuestionsController@from')->name('questionnaire.form.new');
    });

    /** Ajuda */
    Route::group(['prefix' => 'help'], function () {
        Route::get('/', 'AppController@help')->name('app.help');
    });

    /** Route Dashboard */
    Route::group(['prefix' => 'dashboard'], function () {

        Route::livewire('user-appvement-flow-component')
            ->layout('layouts.main', ['title' => 'User - Fluxo de Aprovação'])
            ->name('dashboard.user_approvement_flow');

        Route::get('/budget/{attr}', 'DashboardController@budget')->name('dashboard.orcamento');
        Route::get('/reports/{attr}', 'DashboardController@reports')->name('dashboard.reports');
        Route::get('/graphs/{attr}', 'DashboardController@graphs')->name('dashboard.graphs');
        Route::get('/config', 'DashboardController@config')->name('dashboard.config');

        /// relatorios
        Route::livewire('/relatorios', 'relatorios')->layout('layouts.main', ['title' => 'Relatorios'])->name('reports_');



        Route::livewire('/relatorios/financeiro/projectos', 'relatorio-financeiro-projectos')->layout('layouts.main', ['title' => 'Relatorios'])->name('reports.fin.projects');

        route::livewire('/relatorios/beneficiarios', 'relatorio-beneficiarios')->layout('layouts.main', ['title' => 'Relatorios'])->name('relatorio_beneficiarios');

        // route::livewire('/relatorios/actividades-provincia', 'actividades-provincia')->layout('layouts.main', ['title' => 'Relatorios - Actividades por Provincias'])->name('reports.actividades_provincia');
    });

    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/pde', 'ReportsProjectController@report_financeiro_pde')->name('orcamento_pde');
        Route::get('/api/orcamento/pde/{project}', 'ReportsProjectController@report_financeiro_pde_api')->name('api.relatorios');


        Route::get('/budget/project', 'ReportsProjectController@report_financeiro_project')->name('orcamento_project');
        // Route::get('/api/budget/project/{project}', 'ReportsProjectController@report_financeiro_project_api')
        //     ->name('api.orcamento_project');

        Route::get('/api/budget/project/{project_identifier}', 'ReportsProjectController@report_financeiro_project_api');

        Route::get('/api/export/report/{project}', 'ReportsProjectController@exportOrcamentoPDEToExcel')
            ->name('export.report_orcamento_pde');

        // Relatorio - Beneficiarios
        Route::get('/beneficiarios/pde', 'ReportsProjectController@report_beneficiarios_pde')->name('beneficiarios_pde');
        Route::get('/api/beneficiarios/pde', 'ReportsProjectController@report_beneficiarios_pde_api')->name('api.beneficiarios_pde');

        Route::get('/beneficiarios/projectos', 'ReportsProjectController@report_beneficiarios_project')->name('beneficiarios_project');
        Route::get('/api/beneficiarios/projectos', 'ReportsProjectController@report_beneficiarios_project_api')->name('api.beneficiarios_project');

        // Relatorio - Actividades Approvement Flow
        Route::get('/actividades/solicitacao/aprovacao', 'ReportsProjectController@report_atividades_approvement_flow')
            ->name('atividades_approvement_flow');
        Route::get('/api/actividades/solicitacao/aprovacao', 'ReportsProjectController@report_atividades_approvement_flow_api')
            ->name('api.atividades_approvement_flow');

        // Relatorio - Actividades Solicitcao de Fundos
        Route::get('/actividades/solicitacao', 'ReportsProjectController@report_atividades_solicitacao')
            ->name('atividades_solicitacao');
        Route::get('/api/actividades/solicitacao', 'ReportsProjectController@report_atividades_approvement_flow_api')
            ->name('api.atividades_approvement_flow');

        // Relatorio - Actividades Provincias
        Route::get('/actividades/provincia', 'ReportsProjectController@report_actividades_provincia')->name('atividades_provincia');
        Route::get('/api/actividades/provincia', 'ReportsProjectController@report_atividade_provincia_api')->name('api.atividades_provincia');

        // Relatorio - Actividades PDE
        Route::get('/actividades/pde', 'ReportsProjectController@report_atividades_pde')->name('atividades_pde');
        Route::get('/api/atividades/pde/{project_identifier}', 'ReportsProjectController@report_atividades_pde_api')->name('api.atividades_pde');


        Route::get('/relatorio/orcamento/pde', 'ReportsProjectController@report_data_orcamento_pde')
            ->name('data_orcamento_pde');

        Route::get('/relatorio/execucao-orcamental', 'ReportsProjectController@report_execucao_orcamental')
            ->name('execucao_orcamental');


        Route::get('/relatorio/previsao-plano-orcamental', 'ReportsProjectController@report_previsao_orcamental')
            ->name('prev_orcamental');


        Route::get('/relatorio/general-issues-report', 'ReportsProjectController@general_issues_report')
            ->name('general_issues_report');

        Route::get('/relatorio/general-issues-report-project', 'ReportsProjectController@general_issues_report_project')
            ->name('general_issues_report_project');

        Route::get('/relatorio/general-indicators-report', 'ReportsProjectController@general_indicators_report')
            ->name('general_indicators_report');

        //Export general issues report
        Route::get('/api/exportGI/report/{project}', 'ReportsProjectController@exportGeneralIssuesReportExcel')
            ->name('export.general_issues_report');
        Route::get('/api/exportGI/report/project/{project}', 'ReportsProjectController@exportGeneralIssuesReportProjectExcel')
            ->name('export.general_issues_report_project');
    });

    /**
     * Exports e Relatorios PDF
     */
    Route::group(['prefix' => 'reports_files', 'as' => 'reports_files.'], function () {
        Route::group(['prefix' => 'projects/{project_identifier}', 'as' => 'projects.'], function () {
            // Route::get('export-pdf', 'ExportReportController@relatorio_orcamento');

            Route::get('export/resumo/solicitacao-fundos/{requestNum}/{requestID}', 'ExportReportController@export_resumo_SolicitacaoFundos')
                ->name('export_resumo_solicitacao_fundos');
        });

        Route::group(['prefix' => 'issues/{issue}', 'as' => 'issues.'], function () {
            Route::get('export/relatorio-orcamento', 'ExportReportController@relatorio_orcamento')->name('export_relatorio_orcamento');
        });
    });

    /**
     * Aprovação P. Atividades
     */
    Route::group(['prefix' => 'aprovacao-plano-de-atividades', 'as' => 'activityPlanApprovement.'], function () {
        Route::get('/', 'ActivityPlanApprovementController@index')->name('index');
    });


    Route::group(['prefix' => 'mail'], function () {
        Route::get('/', function () {
            $markdown = new Markdown(view(), config('mail.markdown'));
            return $markdown->render('mails.user.password_change');
        });

        Route::group(['prefix' => 'nivel'], function () {
            Route::get('1', function () {
                $markdown = new Markdown(view(), config('mail.markdown'));
                return $markdown->render('emails.issues.created');
            });
            Route::get('2', function () {
                $markdown = new Markdown(view(), config('mail.markdown'));
                return $markdown->render('emails.issues.created');
            });
        });
    });

    Route::group(['prefix' => 'exports', 'as' => 'exports.'], function () {
        Route::get("/solicitacao_fundos", function () {

            $areas = \App\Models\Enumerations::where('type', 'IssueArea')->get();
            $actividades = \App\Models\Enumerations::where('type', 'IssueActividade')->get();
            $necessidades = \App\Models\Enumerations::where('type', 'IssueNecessidade')->get();

            return view('solicitacaoFundos.exports.index', compact('areas', 'actividades', 'necessidades'));
        });
    });

    Route::group(['prefix' => 'dashbord_admin', 'as' => 'dashbord_admin.'], function () {

        Route::get('/', "DashbordAdminController@uso_sistema")->name('usosistema');
        Route::get('/assiduidade', "DashbordAdminController@assiduidade")->name('assiduidade');
        Route::get('/actividades_reportar', "DashbordAdminController@actividades_reportar")->name('actividades_reportar');
        Route::get('/dados_em_falta', "DashbordAdminController@dados_em_falta")->name('dados_em_falta');
    });

    Route::group(['prefix' => 'plan_aprovemmnt', 'as' => 'plan_aprovemmnt.'], function () {

        Route::get('/', "PlanAprovementFlow@plan_aprovement")->name('plan_Aprovemnt');
    });

    // Route::get('update-RF001x0001', function () {

    //     $approveModels = \App\Models\ApprovementFlowModels::where('customized_type', "Issue")
    //         ->with('approvement_flow')
    //         ->whereHas('approvement_flow')
    //         ->where('role_id', null)
    //         ->with('issue')
    //         ->get();

    //     foreach ($approveModels as $approvementFlow) {
    //         $approvementFlow->role_id = $approvementFlow->approvement_flow->role_id;
    //         $approvementFlow->update(); // Save data into database
    //     }

    //     return $approveModels;
    // });

});
