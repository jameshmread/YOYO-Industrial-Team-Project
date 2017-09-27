<?php

namespace App\Http\Controllers;

use App\Mail\SalesReport;
use App\Store;
use App\User;
use Illuminate\Http\Request;
use App\Transaction;
use App\Colours;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionsReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    const CORS_KEY = 'Access-Control-Allow-Origin';
    const CORS_VALUE = '*';

    /**
     * Will return each transaction with it's store color and the total value of the transaction
     *
     * /api/stores/Spare/total-sales-value/2015-08-01/2015-08-30
     *
     * @param Request $request
     * @return $this
     */
    public function totalSalesValue(Request $request)
    {
        $totalSalesValue = Transaction::where('date', '>=', $request->period1)
            ->where('date', '<=', $request->period2)
            ->where('outlet_name', '=', $request->store_name)
            ->get()
            ->map(function ($item) {
                return [
                    'store_name' => $item['outlet_name'],
                    'store_colour' => Colours::where('store', '=',
                        $item['outlet_name'])->pluck('chart_colour')->first(),
                    'transaction_total_amount' => $item['total_amount'],
                    'date' => $item['date'],
                ];
            });

        return response()
            ->json($totalSalesValue)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    /**
     * Will return each transaction with it's store color and the average of the
     * transaction value as a total of the duration requested
     *
     * /api/stores/Spare/average-sales-value/2015-08-01/2015-08-30
     *
     * @param Request $request
     * @return $this
     */
    public function averageSalesValue(Request $request)
    {
        $averageSalesValue = Transaction::where('date', '>=', $request->period1)
            ->where('date', '<=', $request->period2)
            ->where('outlet_name', '=', $request->store_name)
            ->get();

        $averageSalesValue = $averageSalesValue->map(function ($item) use ($averageSalesValue) {
            return [
                'store_name' => $item['outlet_name'],
                'store_colour' => Colours::where('store', '=',
                    $item['outlet_name'])->pluck('chart_colour')->first(),
                'average_sales_value' => $item['total_amount'] / $averageSalesValue->pluck('total_amount')->sum(),
            ];
        });

        return response()
            ->json($averageSalesValue)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    /**
     * Returns the total amount of customers that performed transactions during a given period
     *
     * /api/stores/Spare/total-customers/2015-08-01/2015-08-30
     *
     * @param Request $request
     * @return $this
     */
    public function totalCustomers(Request $request)
    {
        $totalCustomers = Store::where('outlet_name', '=', $request->store_name)
            ->get()
            ->map(function ($item) use ($request) {
                return [
                    'store_name' => $item['outlet_name'],
                    'store_colour' => Colours::where('store', '=',
                        $item['outlet_name'])->pluck('chart_colour')->first(),
                    'total_customers' => Transaction::where('date', '>=', $request->period1)
                        ->where('date', '<=', $request->period2)
                        ->where('outlet_name', '=', $request->store_name)
                        ->count()
                ];
            });

        return response()
            ->json($totalCustomers)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    /**
     * Return the total number of unique customers that performed transactions during a given period
     *
     * /api/stores/Spare/unique-customers/2015-08-01/2015-08-30
     *
     * @param Request $request
     * @return $this
     */
    public function uniqueCustomers(Request $request)
    {
        $uniqueCustomers = Store::where('outlet_name', '=', $request->store_name)
            ->get()
            ->map(function ($item) use ($request) {
                return [
                    'store_name' => $item['outlet_name'],
                    'store_colour' => Colours::where('store', '=',
                        $item['outlet_name'])->pluck('chart_colour')->first(),
                    'unique_customers' => Transaction::where('date', '>=', $request->period1)
                        ->where('date', '<=', $request->period2)
                        ->where('outlet_name', '=', $request->store_name)
                        ->pluck('customer_id')
                        ->unique()
                        ->count()
                ];
            });

        return response()
            ->json($uniqueCustomers)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    /**
     * Return the total number of users that returned later during this period to make another purchase
     *
     * /api/stores/Spare/retained-customers/2015-08-01/2015-08-30
     *
     * @param Request $request
     * @return $this
     */
    public function retainedCustomers(Request $request)
    {
        $uniqueCustomers = Transaction::where('date', '>=', $request->period1)
            ->where('date', '<=', $request->period2)
            ->where('outlet_name', '=', $request->store_name)
            ->pluck('customer_id')
            ->unique()
            ->flatten();

        $retainedCustomers = Store::where('outlet_name', '=', $request->store_name)
            ->get()
            ->map(function ($item) use ($uniqueCustomers) {
                return [
                    'store_name' => $item['outlet_name'],
                    'store_colour' => Colours::where('store', '=',
                        $item['outlet_name'])->pluck('chart_colour')->first(),
                    'customers_retained' =>
                        $uniqueCustomers->map(function ($customer) use ($item) {
                            return [
                                'customer_retained' => Transaction::where('outlet_name', '=', $item['outlet_name'])
                                        ->where('customer_id', '=', $customer)->count() > 2
                            ];
                        })
                ];
            });

        $retainedCustomers = $retainedCustomers->map(function ($item) {
            $user = 0;

            foreach ($item['customers_retained'] as $value) {
                if ($value['customer_retained']) {
                    $user++;
                }

                return [
                    'store_name' => $item['store_name'],
                    'store_colour' => $item['store_colour'],
                    'customers_retained' => $user,
                ];
            }
        });

        return response()
            ->json($retainedCustomers)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    /**
     * Will generate a transactions report for the user based on the request details
     *
     * @param Request $request
     */
    public function generateTransactionsReport(Request $request)
    {
        $currentMonth = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        Mail::to(User::find($request->user_id))
            ->send(new TransactionsReport(Transaction::where('outlet_name', '=', $request->store_name)
                ->where('date', '>=', $previousMonth)
                ->where('date', '<=', $currentMonth)
                ->get()));
    }

    public function getStores()
    {

        return DB::select('select outlet_name from stores order by outlet_name asc');

    }

    public function updateColour(Request $request)
    {


        DB::table('colours')
            ->where('store', $request->store_name)
            ->update(['chart_colour' => '#' . $request->colour]);

        return;
    }
}

