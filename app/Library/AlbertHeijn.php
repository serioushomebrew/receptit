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
     * @param array $products Ingredient which we want to search in recipes
     * @return object JSON object with results
     */
    public static function searchRecipes($queryList)
    {
        // A list which contains all recipes that matches the product request
        $recipes = [];

        // Search a recipe for each product type
        foreach($queryList as $query) {
            $recipeList = Curl::to(self::$_requestUrl['recipes'])
                ->withData([
                    'personalkey' => self::$_apiKey,
                    'receptingredienten' => $query,
                ])
                ->withOption('SSL_VERIFYPEER', env('API_SSL_ALBERTHEIJN', true))
                ->asJson()
                ->get();

            // For each recipe we need the product listing
            foreach($recipeList as $recipe) {
                // We need to hack this back appending the api key...
                /*$productList = Curl::to($recipe->productenurl . '&personalkey=' . self::$_apiKey)
                    ->withOption('SSL_VERIFYPEER', env('API_SSL_ALBERTHEIJN', true))
                    ->asJson()
                    ->get();*/

                if(!isset($recipe->receptzoektermen))
                    continue;

                $recipeListTags = $recipe->receptzoektermen;
                $recipeListTags = str_replace(' ', '', $recipeListTags);
                $recipeListTags = explode('|', $recipeListTags);

                $maxScore = count($recipeListTags);
                $curScore = 0;
                foreach($recipeListTags as $item) {
                    if(in_array($item, $queryList)) {
                        $curScore++;
                    }
                }
                $score = $curScore / $maxScore;

                // Append the recipe with product to the list
                $recipes[] = [
                    'id' => $recipe->receptid,
                    'tag' => $query,
                    'name' => $recipe->recepttitel,
                    'product-tags' => $recipeListTags,
                    'product-score' => $score,
                    'image' => $recipe->receptafbeelding,
                    //'products' => $productList,
                ];
            }
        }

        // Remove duplicate
        $recipes = array_filter($recipes, function ($item) {
            return true;
        });

        // Sort, based in completed recipe's
        usort($recipes, function($a, $b) {
            if($a['product-score'] > $b['product-score']) {
                return -1;
            } else if($a['product-score'] < $b['product-score']) {
                return 1;
            } else {
                return 0;
            }
        });

        return $recipes;
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
