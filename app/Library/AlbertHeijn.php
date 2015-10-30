<?php

namespace App\Library;

use Ixudra\Curl\Facades\Curl;

class AlbertHeijn
{
    /**
     * @var string $_baseUrl The base url to the Albert Heijn Api
     */
    private static $_baseUrl = 'https://frahmework.ah.nl/ah';

    /**
     * @var string $_apiKey The Albert Heijn Api key
     */
    private static $_apiKey = '';

    public static function apiKey($apiKey)
    {
        self::$_apiKey = $apiKey;
    }

    /**
     * Searches products that match the term
     *
     * @param string $term The search term
     * @return object JSON object with results
     */
    public static function products($term)
    {
        $response =  Curl::to(self::$_baseUrl.'/json/producten')
            ->withData([
                'productomschrijving' => $term,
                'personalkey' => self::$_apiKey,
            ])
            ->get();

        dd($response);
    }

    /**
     * Returns recipes where the ingredient stands in
     *
     * @param string $ingredient Ingredient which we want to search in recipes
     * @return object JSON object with results
     */
    public static function recipes($ingredient)
    {
        $response =  Curl::to(self::$_baseUrl.'/json/recepten')
            ->withData([
                'receptomschrijving' => $ingredient,
                'personalkey' => self::$_apiKey,
            ])
            ->get();

        return $response;
    }
}