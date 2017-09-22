 <?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * API ROUTES
 * 
 * @todo add an authentication mechanism
 */
$router->group([
    'as' => 'api.'
], function (Router $router) {
    $router->get('/transactions/uniqueUsersPerStore', 'APIController@retainedUsersPerStore')->name('retainedUsersPerStore');
    $router->get('/unique-users-per-store', 'APIController@uniqueUsersPerStore')->name('uniqueUsersPerStore');
    $router->get('/transactions/averagesales', 'APIController@averageSalesPerStore')->name('averageSales');
    $router->get('/transactions/totalsales', 'APIController@totalSales')->name('totalSales');
    $router->get('/transactions/users/volumeperstore', 'APIController@userVolumePerStore')->name('userVolumePerStore');
    $router->get('/transactions/period/{period1}/{period2}', 'APIController@periodToPeriod')->name('periodToPeriod');
    $router->get('/transactions/recent', 'APIController@recentTransactions')->name('recentTransactions');
    $router->get('/transactions/{year}', 'APIController@dmyListing')->name('yearlyListing');
    $router->get('/transactions/{year}/{month}', 'APIController@dmyListing')->name('monthlyListing');
    $router->get('/transactions/{year}/{month}/{day}', 'APIController@dmyListing')->name('dailyListing');
});
