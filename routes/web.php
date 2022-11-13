<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Artisan::call('view:clear');

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

Route::get('/', 'HomeController@index');
Route::match(['get', 'post'], '/search', 'HomeController@search');
Route::get('/parser/{tag}/{max}', 'HomeController@parser');

/* Wallpapers */
Route::match(['get', 'post'], '/wallpaper/get', 'WallpaperController@get');
Route::match(['get', 'post'], '/wallpaper/getList', 'WallpaperController@getList');
Route::match(['get', 'post'], '/wallpaper/download', 'WallpaperController@download');