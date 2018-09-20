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
#会员登录注册
Route::get('/login','Home\MemberController@toLogin');
Route::get('/register','Home\MemberController@toRegister');

Route::group(['prefix'=>'service'],function(){
    #验证码
    Route::get('validate_code/create','Service\ValidateController@create');
    #手机号
    Route::post('validate_phone/sendSms','Service\ValidateController@sendSms');
    #后台注册验证
    Route::post('register','Service\MemberController@register');
    #登录
    Route::post('login','Service\MemberController@login');
    Route::get('category/parent_id/{parent_id}','Service\BookController@getCategoryByParentId');
});

#书籍类别
Route::get('/category','Home\BookController@toCategory');

Route::get('/product/category_id/{category_id}','Home\BookController@toProduct');
Route::get('/product/{product_id}', 'Home\BookController@toPdtContent');