<?php

Route::post('/proyecto02/login', 'LoginController@login');
Route::get('/proyecto02/logout', 'LoginController@logout');

Route::resource('/proyecto02/user', 'UserController', 'json');
Route::get('/proyecto02/user/others/(:number)', 'UserController@otherUser');
Route::resource('/proyecto02/meeting', 'MeetingController', 'json');
Route::get('/proyecto02/meeting/user/(:number)', 'MeetingController@forUser');

Route::dispatch();

?>