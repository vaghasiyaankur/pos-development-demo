<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AuthController;


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

Route::get('/logout', [AuthController::class , 'logout']);

Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::post('login', 'LoginController@submit')->middleware('actch');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

Route::get('slider', [SliderController::class, 'index']);
Route::get('{any}', function(){
    return view('index');
})->where('any','.*');

