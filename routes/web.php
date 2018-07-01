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

Route::get('/', function () {
    return view('welcome');
});

//首页
Route::get('/','StaticPagesController@home')->name('home');
//关于页
Route::get('/about','StaticPagesController@about')->name('about');
//帮助页
Route::get('/help','StaticPagesController@help')->name('help');

//注册页
Route::get('signup','UsersController@create')->name('signup');;
