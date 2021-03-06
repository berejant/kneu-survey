<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function()
{
    Route::get('/', ['as' => 'admin.list', 'uses' => 'AdminController@showList']);

    Route::get('/teacher/{teacher}', ['as' => 'admin.teacher', 'uses' => 'AdminController@teacher'])
        ->where('teacher', '[0-9]+');

    Route::get('/launch', ['as' => 'admin.launchStatus', 'uses' => 'AdminController@launchStatus']);
    Route::post('/launch', ['as' => 'admin.launchChangeStatus', 'uses' => 'AdminController@launchChangeStatus']);
    Route::get('/launch/finish', ['as' => 'admin.launchChangeStatusFinish', 'uses' => 'AdminController@launchChangeStatusFinish']);
});


Route::get('/{student}/{secret}/', [
    'as' => 'survey.auth', 'uses' => 'StudentController@auth'
]);

Route::get('/', [
    'as' => 'survey.start', 'uses' => 'SurveyController@start'
]);

Route::get('/{teacher}', [
    'as' => 'survey.questionnaire', 'uses' => 'SurveyController@questionnaire'
])->where('teacher', '[0-9]+');

Route::post('/save', [
    'as' => 'survey.saveQuestionnaire', 'uses' => 'SurveyController@saveQuestionnaire'
]);

Route::get('/finish', [
    'as' => 'survey.finish', 'uses' => 'SurveyController@finish'
]);

Route::post('/restart', [
    'as' => 'survey.restart', 'uses' => 'SurveyController@restart'
]);

Route::get('/studentsCompleted.json', 'StudentController@completedJson');
