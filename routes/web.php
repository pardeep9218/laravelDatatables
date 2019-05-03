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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\Adminauth\AdminLoginController@showLoginForm')->name('admin-login');
    Route::post('/login', 'Auth\Adminauth\AdminLoginController@login')->name('adminlogin');
    Route::post('/logout', 'Auth\Adminauth\AdminLoginController@logout')->name('adminlogout');
    Route::get('/register', 'Auth\Adminauth\AdminRegisterController@showRegistrationForm')->name('admin-register');
    Route::post('/register', 'Auth\Adminauth\AdminRegisterController@register')->name('adminregister');
    Route::group(['middleware' => 'auth:admin'], function() {
        Route::get('/', 'AdminController@index')->name('dashboard');
        Route::get('/dashboard', 'AdminController@index')->name('dashboard');
        Route::resource('/category', 'CategoryController');
        Route::get('/categories', 'CategoryController@categories')->name('allcategory');
        Route::post('/categories-datatable', 'CategoryController@categoriesDatatable')->name('categoriesDatatable');
        Route::resource('/contact', 'ContactController');
        Route::post('/contact-datatable', 'ContactController@contactDatatable')->name('contact.datatable');
        Route::resource('/about', 'AboutController');
        Route::resource('/size', 'SizeController');
        Route::post('/getsize', 'SizeController@getSize');
        Route::post('/size-datatable', 'SizeController@sizeDatatable')->name('size.datatable');
        Route::resource('/product', 'ProductController');
        Route::post('/products-datatable', 'ProductController@productsDatatable')->name('productsDatatable');
        Route::post('/delete-color', 'ColorController@deleteColor');
	});
});
