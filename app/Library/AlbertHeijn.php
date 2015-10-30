<?php

namespace App\Library;

use Ixudra\Curl\Facades\Curl;

class AlbertHeijn
{
    private $_apiKey = '';

    public static function apiKey($apiKey)
    {
        self::_apiKey = $apiKey;
    }

    /**
     * Searches products that match the term
     *
     * @param string $term The search term
     * @return object JSON object with results
     */
    public function products($term)
    {
        return Curl::to('https://frahmework.ah.nl/ah/json/producten')
            ->withData( array(
                'productomschrijving'   => $term,
                'personalkey'           => self::_apiKey
                ) )
            ->get();
    }
}
