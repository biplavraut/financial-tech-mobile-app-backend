<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class NepseController extends Controller
{
    //
    public function market(){
        $client = new Client();
        $response = $client->get('http://149.129.132.253:5000/nepse-data/market-open');
        $data = json_decode($response->getBody(), true); // Convert the JSON response to an associative array
        return response()->json(['status' => true, 'data' => $data, 'statusCode' => 200], 200);
        //return $data;
    }
    public function topGainer(){
        // ...
        // Retrieve cached data
        $cachedData = Cache::get('api_top_gainer');
        if ($cachedData !== null) {
            // Data was found in the cache
            // Process or use the cached data
            $cachedDataArray = json_decode($cachedData, true);
            //return $cachedDataArray;
        } else {
            // Data was not found in the cache
            // Fetch and store the data again
            $client = new Client();
            $response = $client->get('http://149.129.132.253:5000/top-ten/top-gainer?all=true');
            $apiData = json_decode($response->getBody(), true); // Convert the JSON response to an associative array

            // Store API data in cache for 1 hour
            Cache::put('api_top_gainer', json_encode($apiData), now()->addMinutes(15));

            // To retrieve the cached data
            $cachedData = Cache::get('api_top_gainer');
            $cachedDataArray = json_decode($cachedData, true);

            //return $cachedDataArray;
        }
        return response()->json(['status' => true, 'data' => $cachedDataArray, 'statusCode' => 200], 200);  
    }

    public function topLoser()
    {
        // ...
        // Retrieve cached data
        $cachedData = Cache::get('api_top_loser');
        if ($cachedData !== null) {
            // Data was found in the cache
            // Process or use the cached data
            $cachedDataArray = json_decode($cachedData, true);
            //return $cachedDataArray;
        } else {
            // Data was not found in the cache
            // Fetch and store the data again
            $client = new Client();
            $response = $client->get('http://149.129.132.253:5000/top-ten/top-loser?all=true');
            $apiData = json_decode($response->getBody(), true); // Convert the JSON response to an associative array

            // Store API data in cache for 1 hour
            Cache::put('api_top_loser', json_encode($apiData), now()->addMinutes(15));

            // To retrieve the cached data
            $cachedData = Cache::get('api_top_loser');
            $cachedDataArray = json_decode($cachedData, true);

            //return $cachedDataArray;
        }
        return response()->json(['status' => true, 'data' => $cachedDataArray, 'statusCode' => 200], 200);  
    }

    public function subIndices()
    {
        // ...
        // Retrieve cached data
        $cachedData = Cache::get('api_sub_indices');
        if ($cachedData !== null) {
            // Data was found in the cache
            // Process or use the cached data
            $cachedDataArray = json_decode($cachedData, true);
            //return $cachedDataArray;
        } else {
            // Data was not found in the cache
            // Fetch and store the data again
            $client = new Client();
            $response = $client->get('http://149.129.132.253:5000/');
            $apiData = json_decode($response->getBody(), true); // Convert the JSON response to an associative array

            // Store API data in cache for 1 hour
            Cache::put('api_sub_indices', json_encode($apiData), now()->addHour());

            // To retrieve the cached data
            $cachedData = Cache::get('api_sub_indices');
            $cachedDataArray = json_decode($cachedData, true);

            //return $cachedDataArray;
        }
        return response()->json(['status' => true, 'data' => $cachedDataArray, 'statusCode' => 200], 200);  
    }

    public function securitiesListing()
    {
        // ...
        // Retrieve cached data
        $cachedData = Cache::get('api_securities_listing');
        if ($cachedData !== null) {
            // Data was found in the cache
            // Process or use the cached data
            $cachedDataArray = json_decode($cachedData, true);
            //return $cachedDataArray;
        } else {
            // Data was not found in the cache
            // Fetch and store the data again
            $client = new Client();
            $response = $client->get('http://149.129.132.253:5000/security?nonDelisted=true');
            $apiData = json_decode($response->getBody(), true); // Convert the JSON response to an associative array

            // Store API data in cache for 1 hour
            Cache::put('api_securities_listing', json_encode($apiData), now()->addHour());

            // To retrieve the cached data
            $cachedData = Cache::get('api_securities_listing');
            $cachedDataArray = json_decode($cachedData, true);

            //return $cachedDataArray;
        }
        return response()->json(['status' => true, 'data' => $cachedDataArray, 'statusCode' => 200], 200);  
    }

    public function securityDailyTradeStat(){
        // ...
        // Retrieve cached data
        $cachedData = Cache::get('api_security_daily_trade_stat');
        if ($cachedData !== null) {
            // Data was found in the cache
            // Process or use the cached data
            $cachedDataArray = json_decode($cachedData, true);
            //return $cachedDataArray;
        } else {
            // Data was not found in the cache
            // Fetch and store the data again
            $client = new Client();
            $response = $client->get('http://149.129.132.253:5000/securityDailyTradeStat/58');
            $apiData = json_decode($response->getBody(), true); // Convert the JSON response to an associative array

            // Store API data in cache for 1 hour
            Cache::put('api_security_daily_trade_stat', json_encode($apiData), now()->addHour());

            // To retrieve the cached data
            $cachedData = Cache::get('api_security_daily_trade_stat');
            $cachedDataArray = json_decode($cachedData, true);

            //return $cachedDataArray;
        }
        return response()->json(['status' => true, 'data' => $cachedDataArray, 'statusCode' => 200], 200);  
    }

    
}
