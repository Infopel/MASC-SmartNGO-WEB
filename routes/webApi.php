<?php

Auth::routes();

Route::group(['prefix' => 'web/api'], function () {

    Route::group(['prefix' => 'projects'], function () {
        Route::get('{project}', 'ProjectsController@listChilds')->name('programs');
    });


    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', '\App\Http\Controllers\Api\WebAuth\DashboardControllerWebApi@index');
        Route::get('/datagraph', '\App\Http\Controllers\Api\WebAuth\DashboardControllerWebApi@iniGrafico');
    });


    /**
     * Relatorios
     */
    Route::group(['prefix' => 'reports'], function () {
        // Acticiades Projecto -> getProjectByParent
        Route::get('/activity/pde/{project}/projects', 'ReportsActividadesProject@getProjectByParent');
        Route::get('/activity/pde/{project}/activity', 'ReportsActividadesProject@getActivityByParent');
        Route::get('/activity/pde/{project}/activityByDate', 'ReportsActividadesProject@getActivityByDate');
        // Export
        Route::get('/activity/pde/{project}/activity/export', 'ReportsActividadesProject@exportData')
            ->name('export.issues_report');

        // Relatorio Orcamento PDE
        Route::get('/rel/butget/pde/{project}', 'ReportsPDEController@show')->name('budget.pde');
        // Route::get('/rel/butget/pde', 'ReportsPDEController@index')->name('budget.pde');


        Route::get('/actividades/approvement-flow/', 'ReportsSolicitacaoFundosController@approvement_flow');
        Route::get('export/actividades/approvement-flow/', 'ReportsSolicitacaoFundosController@exportData');


        Route::get('/general_issues_report/{project}', 'ReportsProjectController@apiGeneralReports');
        Route::get('/general_indicators_report/{project}', 'ReportsProjectController@apiGeneralReportIndicators');
        Route::get('/general_issues_report_project/{project}', 'ReportsProjectController@apiGeneralReportProject');
        Route::get('/general_issues/{project}', 'ReportsProjectController@apiGeneralReportsProject');
    });
});


/**
 * Reports Routes
 */
Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    // Relatorio - Actividades Projecto
    Route::get('/activity/project/', 'ReportsActividadesProject@index')->name('actividades_project');

    // Relatorio Orcamento Projecto
    Route::get('/rel/butget/project', 'ReportsProjectController@index')->name('data_orcamento_project');
});
