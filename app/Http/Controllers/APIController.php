<?php
/**
 * Created by PhpStorm.
 * User: Carsten
 * Date: 23/11/2017
 * Time: 17:05
 */

namespace App\Http\Controllers;


class APIController
{
    //Example from Industrial Team Project

//    /**
//     * Return the total number of unique customers that performed transactions during a given period
//     *
//     * /api/stores/Spare/unique-customers/2015-08-01/2015-08-30
//     *
//     * @param Request $request
//     * @return $this
//     */
//    public function uniqueCustomers(Request $request)
//    {
//        $uniqueCustomers = Store::where('outlet_name', '=', $request->store_name)
//            ->get()
//            ->map(function ($item) use ($request) {
//                return [
//                    'store_name' => $item['outlet_name'],
//                    'store_colour' => Colours::where('store', '=',
//                        $item['outlet_name'])->pluck('chart_colour')->first(),
//                    'unique_customers' => Transaction::where('date', '>=', $request->period1)
//                        ->where('date', '<=', $request->period2)
//                        ->where('outlet_name', '=', $request->store_name)
//                        ->pluck('customer_id')
//                        ->unique()
//                        ->count()
//                ];
//            });
//        return response()
//            ->json($uniqueCustomers)
//            ->header(self::CORS_KEY, self::CORS_VALUE);
//    }




}