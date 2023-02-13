<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

//Auth::routes();

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'ApiDashboardController@index');
    Route::get('/datagraph', 'ApiDashboardController@iniGrafico');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'ApiUsersController@index');
});

Route::group(['prefix' => 'projects'], function () {
    Route::get('/', 'ApiProjectsController@index');
    Route::get('/id/{parent}', 'ApiProjectsController@project_budget');
});

Route::group(['prefix' => 'api'], function () {
    Route::get('/issues', 'IssuesController@getActividadesAlocadasByUSer');
    //
});
Route::post('getActividadesPendentesAlocadasByUser', 'AppController@getActividadesPendentesAlocadasByUser');

//Route::post('cadastarActividade', 'AppController@cadatrarActividade');
//Route::post('reportarActividade', 'AppController@reportar');

//Route::post('login', [UserController::class, 'login']);
Route::post('folege/{project}', 'ReportsProjectController@apiGeneralReportsProject');

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');


Route::group(['middleware' => 'auth:api'], function(){
	//Rotas protegidas da API
});
