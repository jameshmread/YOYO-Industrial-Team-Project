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

use Illuminate\Routing\Router;

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/**
 * GUEST ROUTES
 */
$router->group([
    'middleware' => ['web', 'guest']
], function (Router $router) {
    $router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $router->post('login', 'Auth\LoginController@login');
});

/**
 * AUTH ROUTES
 */
$router->group([
    'middleware' => ['web', 'auth']
], function (Router $router) {
    $router->post('logout', 'Auth\LoginController@logout')->name('logout');
    $router->get('/profile/{user}/edit', 'UserController@edit')->name('user.edit');
    $router->put('/profile/{user}', 'UserController@update')->name('user.update');
    $router->get('/user/reports', 'UserController@reports')->name('user.reports');
});

/**
 * DATA ROUTES
 */
$router->group([
    'middleware' => ['web', 'auth', 'report']
], function (Router $router) {
    $router->get('/data/stores/sales', 'DataController@salesOverDates')->name('store.date');
    $router->get('/data/stores/average', 'DataController@AverageSales')->name('store.revenue');
    $router->get('/data/users/retained', 'DataController@retainedCustomersPerStore')->name('store.retained');
    $router->get('/data/stores/unique', 'DataController@uniqueCustomersPerStore')->name('store.unique');
    $router->get('/data/stores/total', 'DataController@totalSalesPerStore')->name('store.total');
    $router->get('/data/users/volume', 'DataController@userVolumePerStore')->name('user.volumeperstore');
});

/**
 * ADMIN ROUTES
 */
$router->group([
    'middleware' => ['web', 'auth', 'admin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function (Router $router) {
    $router->get('/', 'AdminController@index')->name('dashboard');
    $router->resource('/users', 'AdminUserController')->except('show');
    $router->get('/csvupload', 'CSVController@index')->name('upload.index');
    $router->post('/csvupload', 'CSVController@upload')->name('upload');
    $router->get('/colours', 'AdminController@storeColourPicker')->name('store.colour');

});
