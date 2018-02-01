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
Route::get('/', 'PageController@home');


Route::post('/upload_image', 'FlickrController@upload');
Route::get('/logout_flickr', 'FlickrController@logout');
Route::get('/get_access_token', 'FlickrController@getAccessToken');
Route::get('/my_flickr', 'FlickrController@myFlickrView');
Route::post('/show_flicker_image_info', 'FlickrController@showFlickerImageInfo');
Route::post('/set_flicker_image_info', 'FlickrController@setFlickerImageInfo');
Route::get('/set_write_oauth_token', 'FlickrController@setWriteOauthToken');
Route::post('/flickr_image_upload', 'FlickrController@flickrImageUpload');


