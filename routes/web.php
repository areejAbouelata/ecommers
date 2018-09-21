<?php

event(new App\Events\UserHasRegistered());


Route::get('/', function () {
    return view('pages.home');
});

Route::resource('flyers', 'FlyersController');

Route::post('/flyers-store', 'FlyersController@store');//why not resource controller

Route::get('{zip}/{street}', 'FlyersController@show');

Route::post('{zip}/{street}/photos', ['as' => 'store-photo-path', 'uses' => 'FlyersController@addPhoto']);

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('boss', ['middleware' => 'admin', function () {
    return 'hello areej' ;
}]);
