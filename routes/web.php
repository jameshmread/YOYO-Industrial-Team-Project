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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

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
    $router->post('logout', 'Auth\LoginController@logout')->name('logout');
    $router->get('/profile/{user}/edit', 'UserController@edit')->name('user.edit');
    $router->put('/profile/{user}', 'UserController@update')->name('user.update');
});

/**
 * DATA ROUTES
 */
$router->group([
    'middleware' => ['web', 'auth', 'report']
], function (Router $router) {
    $router->get('/data/stores', 'DataController@displayAngularPage')->name('angular');
    $router->get('/data/users/volumeperstore', 'DataController@userVolumePerStore')->name('user.volumeperstore');
    $router->get('/data/users/spendingpath', 'DataController@userSpendingPath')->name('user.spendingpath');
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
});
