<?php

Route::group(['prefix'=>'api/lms','middleware'=>['basicAuth']],function(){
  Route::get('user/all','LmsApi\Controllers\UserApiController@getAll');
  Route::get('user/deactivated','LmsApi\Controllers\UserApiController@getDeactivatedUsers');
  Route::post('user/create','LmsApi\Controllers\UserApiController@createUsers');
  Route::post('user/deactivate','LmsApi\Controllers\UserApiController@destroy');
  Route::post('user/activate','LmsApi\Controllers\UserApiController@activateUsers');
});

Route::group(['prefix'=>'api/lms/course','middleware'=>['basicAuth']],function(){
  Route::get('all','LmsApi\Controllers\CourseApiController@getAll');
  Route::post('update','LmsApi\Controllers\CourseApiController@coursesUpdate');
});


Route::group(['prefix'=>'api/lms/course/completions','middleware'=>['basicAuth']],function(){
  Route::get('all','LmsApi\Controllers\CourseCompletionsApiController@getAll');
  Route::post('update','LmsApi\Controllers\CourseCompletionsApiController@coursesUpdate');
});

Route::group(['prefix'=>'csv/lms/course/completions','middleware'=>['auth','roles']],function(){
  Route::get('create','LmsApi\Controllers\CourseCompletionsCsvController@create');
  Route::post('create','LmsApi\Controllers\CourseCompletionsCsvController@store');
});


Route::group(['prefix'=>'lms/course/completions','middleware'=>['auth','roles']],function(){
  Route::get('','LmsApi\Controllers\CourseCompletionsController@index');
  Route::get('create','LmsApi\Controllers\CourseCompletionsController@create');
  Route::post('create','LmsApi\Controllers\CourseCompletionsController@store');
  Route::get('view/{id}','LmsApi\Controllers\CourseCompletionsController@show');
  Route::get('edit/{id}','LmsApi\Controllers\CourseCompletionsController@edit');
  Route::post('edit/{id}','LmsApi\Controllers\CourseCompletionsController@update');
  Route::get('delete/{id}','LmsApi\Controllers\CourseCompletionsController@destroy');
});
