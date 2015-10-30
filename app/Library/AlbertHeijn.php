<?php

namespace App\Library;

class AlbertHeijn
{
    private $_apiKey = '';

    public static function apiKey($apiKey)
    {
        self::_apiKey = $apiKey;
    }

    public function products()
    {

    }
}
