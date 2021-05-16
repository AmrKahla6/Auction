<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', function () {
    return redirect('/dashboard/index');
  });


  Route::prefix('dashboard')->name('dashboard.')->namespace('dashboard')->middleware('auth')->group(function(){
    Route::get('/index', 'DashboardController@index')->name('index');
  });
