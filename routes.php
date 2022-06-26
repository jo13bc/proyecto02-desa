<?php

Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');

Route::resource('/user', 'UserController', 'json');
Route::get('/user/others/(:number)', 'UserController@otherUser');
Route::resource('/meeting', 'MeetingController', 'json');
Route::get('/meeting/user/(:number)', 'MeetingController@forUser');

Route::dispatch();

?>