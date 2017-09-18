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
    'middlware' => ['web', 'guest']
], function (Router $router) {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
});

/**
 * AUTH ROUTES
 */
$router->group([
    'middlware' => ['web', 'auth']
], function (Router $router) {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('demo', function(){
        return view('Auth\demo');
    });

    Route::get('linechart', function(){
        return view('Auth\transactionchart');
    });

    Route::get('piechart', function(){
        return view('Auth\transactionchartPie');
    });

    Route::get('barchart', function(){
        return view('Auth\transactionchartBar');
    });
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

/**
 * API ROUTES
 */
$router->group([
    'middleware' => ['auth'],
    'prefix' => 'api',
    'as' => 'api.'
], function (Router $router) {
    $router->get('/transactions/period/{period1}/{period2}', 'APIController@periodToPeriod')->name('periodToPeriod');
    $router->get('/transactions/recent', 'APIController@recentTransactions')->name('recentTransactions');
    $router->get('/transactions/{year}', 'APIController@dmyListing')->name('yearlyListing');
    $router->get('/transactions/{year}/{month}', 'APIController@dmyListing')->name('monthlyListing');
    $router->get('/transactions/{year}/{month}/{day}', 'APIController@dmyListing')->name('dailyListing');
});
