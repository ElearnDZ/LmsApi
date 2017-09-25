<?php

Route::group(['prefix'=>'api/lms'],function(){
  Route::get('user/all','LmsApi\Controllers\UserApiController@getAll');
  Route::get('user/deactivated','LmsApi\Controllers\UserApiController@getDeactivatedUsers');
  Route::post('user/create','LmsApi\Controllers\UserApiController@createUsers');
  Route::post('user/delete','LmsApi\Controllers\UserApiController@destroy');
});
