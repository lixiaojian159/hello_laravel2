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
Route::get('signup','UsersController@create')->name('signup');
//用户模块
Route::resource('users','UsersController');
//用户登录
Route::get('login','SessionsController@create')->name('login');
//用户验证
Route::post('login','SessionsController@store')->name('login');
//用户退出
Route::delete('logout','SessionsController@destroy')->name('logout');
//用户邮箱认证
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');
