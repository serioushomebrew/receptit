<?php

namespace App\Library;

// use Curl;
use Ixudra\Curl\Facades\Curl;

class AlbertHeijn
{
    /**
     * A list of API request urls
     * @var array
     */
    private static $_requestUrl = [
        'products' => 'https://frahmework.ah.nl/ah/json/producten',
        'recipes' => 'https://frahmework.ah.nl/ah/json/recepten',
    ];

    /**
     * The AlbertHeijn API key for accessing their api data
     * @var string
     */
    private static $_apiKey = '';

    /**
     * Set the API key to the private variable
     * @param string $apiKey The AlbertHeijn API key
     */
    public static function setApiKey($apiKey)
    {
        self::$_apiKey = $apiKey;
    }

    /**
     * Search the AlbertHeijn
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public static function searchProducts($query)
    {
        $response = Curl::to(self::$_requestUrl['products'])
            ->withData([
                'personalkey' => self::$_apiKey,
                'productomschrijving' => $query,
            ])
            ->withOption('SSL_VERIFYPEER', env('API_SSL_ALBERTHEIJN', true))
            ->asJson()
            ->get();

        return $response;
    }

    /**
     * Returns recipes where the ingredient stands in
     *
     * @param string $query Ingredient which we want to search in recipes
     * @return object JSON object with results
     */
    public static function searchRecipes($query)
    {
        $response =  Curl::to(self::$_requestUrl['recipes'])
            ->withData([
                'personalkey' => self::$_apiKey,
                'receptomschrijving' => $query,
            ])
            ->withOption('SSL_VERIFYPEER', env('API_SSL_ALBERTHEIJN', true))
            ->asJson()
            ->get();

        return $response;
    }

    /**
     * Default request
     *
     * @param string $url The url
     * @return mixed
     */
    public static function request($url)
    {
        $response =  Curl::to($url.'&personalkey='.self::$_apiKey)
            ->withOption('SSL_VERIFYPEER', env('API_SSL_ALBERTHEIJN', true))
            ->asJson()
            ->get();

        return $response;
    }
}
