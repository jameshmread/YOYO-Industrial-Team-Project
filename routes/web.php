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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

$router->group([
    'middleware' => ['auth'],
    'prefix' => 'api',
    'as' => 'api.'
], function (Router $router) {
    $router->get('/transactions/recent', 'APIController@recentTransactions')->name('recentTransactions');
    $router->get('/transactions/{year}', 'APIController@yearlyListing')->name('yearlyListing');
    $router->get('/transactions/{year}/{month}', 'APIController@monthlyListing')->name('monthlyListing');
    $router->get('/transactions/{year}/{month}/{day}', 'APIController@dailyListing')->name('dailyListing');
    $router->get('/transactions/{period1}/{period2}', 'APIController@periodToPeriod')->name('periodToPeriod');
});