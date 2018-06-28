<?php

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


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@dashboard');
Route::get('dashboard/{extId}', ['uses' => 'DashboardController@project']);
Route::get('dashboard/sprint/{extId}', ['uses' => 'DashboardController@sprint']);
Route::get('dashboard/sprint/ticket/{extId}', ['uses' => 'DashboardController@ticketBySprintId']);

Route::get('/dashboard', 'DashboardController@dashboard');
Route::get("dashboard/api/edit/ticket/{extId}/status/{status_id}", ['uses' => 'DashboardController@editStatusByTicketId']);
Route::get('dashboard/api/details/{extId}', ['uses' => 'DashboardController@details']);

Route::group(['middleware' => ['role:admin']], function() {
    Route::get('/user', 'UserController@index');
    Route::get('/user/create', 'UserController@createGet');
    Route::post('/user/create', 'UserController@createPost');
    Route::get('/user/edit/{extId}', 'UserController@editGet');
    Route::post('/user/edit/{extId}', 'UserController@editPost');
    Route::get('/user/delete/{extId}', 'UserController@delete');
});

Route::group(['middleware' => ['role:teamleader']], function() {
    Route::get('/create', 'CreateController@create');

    Route::get('/project/create', 'ProjectController@createGet');
    Route::post('/project/create', 'ProjectController@createPost');
    Route::get('/project/edit/{extId}', 'ProjectController@editGet');
    Route::post('/project/edit/{extId}', 'ProjectController@editPost');
    Route::get('/project/delete/{extId}', 'ProjectController@delete');

    Route::get('/sprint/create', 'SprintController@createGet');
    Route::post('/sprint/create', 'SprintController@createPost');
    Route::get('/sprint/edit/{extId}', 'SprintController@editGet');
    Route::post('/sprint/edit/{extId}', 'SprintController@editPost');
    Route::get('/sprint/delete/{extId}', 'SprintController@delete');

    Route::get('/ticket/create', 'TicketController@createGet');
    Route::post('/ticket/create', 'TicketController@createPost');
    Route::get('/ticket/edit/{extId}', 'TicketController@editGet');
    Route::post('/ticket/edit/{extId}', 'TicketController@editPost');
    Route::get('/ticket/delete/{extId}', 'TicketController@delete');
});
