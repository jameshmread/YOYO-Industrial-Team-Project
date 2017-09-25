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
 */
$router->group([
    'as' => 'api.'
], function (Router $router) {
    $router->get('/stores/{store_name}/total-sales-value/{period1}/{period2}', 'APIController@totalSalesValue')->name('stores.total_sales_value');
    $router->get('/stores/{store_name}/average-sales-value/{period1}/{period2}', 'APIController@averageSalesValue')->name('stores.average_sales_value');
    $router->get('/stores/{store_name}/total-customers/{period1}/{period2}', 'APIController@totalCustomers')->name('stores.total_customers');
    $router->get('/stores/{store_name}/unique-customers/{period1}/{period2}', 'APIController@uniqueCustomers')->name('stores.unique_customers');
    $router->get('/stores/{store_name}/retained-customers/{period1}/{period2}', 'APIController@retainedCustomers')->name('stores.retained_customers');
    $router->post('/reports/transactions', 'APIController@generateTransactionsReport')->name('reports.transactions');
    $router->post('/reports/sales', 'APIController@generateSalesReport')->name('reports.sales');
});
