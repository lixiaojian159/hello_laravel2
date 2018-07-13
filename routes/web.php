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
//显示重置密码的邮箱发送页面
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//用户在重置密码的填写邮箱后提交,后台处理后发送给用户邮箱和验证字段的拼接
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
//微博发布和删除
Route::resource('statuses','StatusesController',[ 'only' => ['store','destroy'] ]);
