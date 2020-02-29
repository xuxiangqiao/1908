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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Index\IndexController@index');
Route::view('/login','index.login');

Route::get('/news', 'NewsController@index');
Route::get('/news/create', 'NewsController@create')->name('别名');
Route::post('/news/store', 'NewsController@store');
//唯一性验证
Route::post('/news/checkOnly', 'NewsController@checkOnly');
Route::get('/news/edit/{id}', 'NewsController@edit');
Route::get('/news/destroy/{id}', 'NewsController@destroy');


//商品分类
Route::get('/category', 'CategoryController@index')->middleware('islogin');
Route::get('/category/create', 'CategoryController@create');
Route::post('/category/store', 'CategoryController@store');

Route::view('/admin/login','login');
Route::post('/admin/logindo', 'LoginController@logindo');


//商品
Route::get('/goods/create', 'GoodsController@create');
Route::post('/goods/store', 'GoodsController@store');
Route::get('/goods', 'GoodsController@index');
Route::get('/goods/show/{id}', 'GoodsController@show');

//设置cookie
Route::get('/setcookie', 'Index\IndexController@setCookie');
//发送短信
Route::get('/send', 'Index\LoginController@ajaxsend');
Route::get('/reg', 'Index\LoginController@reg');
Route::post('/regdo', 'Index\LoginController@regdo');

//发送邮件
Route::get('/sendemail', 'Index\LoginController@sendEmail');

Route::get('/new', 'NewController@index');


Route::name('admin.')->group(function () {
	Route::get('users', function () {
	// 新的路由名称为 "admin.users"
		echo 123;
	})->name('users');
});