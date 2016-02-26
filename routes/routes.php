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
Route::group(['prefix' => 'announcement-management/'], function() {
  Route::group(['middleware' => ['auth']], function () {
    Route::get('list', '\Klsandbox\AnnouncementManagement\Http\Controllers\AnnouncementManagementController@getList');
    Route::get('view/{id}', '\Klsandbox\AnnouncementManagement\Http\Controllers\AnnouncementManagementController@getView');

    Route::group(['middleware' => ['auth.admin']], function () {
      Route::get('create', '\Klsandbox\AnnouncementManagement\Http\Controllers\AnnouncementManagementController@getCreate');
      Route::post('create', '\Klsandbox\AnnouncementManagement\Http\Controllers\AnnouncementManagementController@postCreate');
    });
  });
});