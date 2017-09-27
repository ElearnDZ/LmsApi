<?php

Route::group(['prefix'=>'api/lms'],function(){
  Route::get('user/all','LmsApi\Controllers\UserApiController@getAll');
  Route::get('user/deactivated','LmsApi\Controllers\UserApiController@getDeactivatedUsers');
  Route::post('user/create','LmsApi\Controllers\UserApiController@createUsers');
  Route::post('user/deactivate','LmsApi\Controllers\UserApiController@destroy');
  Route::post('user/activate','LmsApi\Controllers\UserApiController@activateUsers');
});

Route::group(['prefix'=>'api/lms/course'],function(){
  Route::get('all','LmsApi\Controllers\CourseApiController@getAll');
  Route::post('update','LmsApi\Controllers\CourseApiController@coursesUpdate');
});


Route::group(['prefix'=>'api/lms/course/completions'],function(){
  Route::get('all','LmsApi\Controllers\CourseCompletionsApiController@getAll');
  Route::post('update','LmsApi\Controllers\CourseCompletionsApiController@coursesUpdate');
});
