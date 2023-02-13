<?php

Auth::routes();

Route::group(['prefix' => 'bugs/center', 'as' => 'bugCenter.'], function () {

    Route::get('/', "BugsCenterController@bug_solicitacaoFundos")->name('solicitacaoFundos');
});
