<?php

namespace App\Http\Controllers\Api;

use App\Library\AlbertHeijn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function postLiveSearchProductTags(Request $request)
    {
        AlbertHeijn::setApiKey(env('API_KEY_ALBERTHEIJN'));

        // Require a query string in order to continue
        if (!$request->has('query')) {
            return response()->json([
                'error' => 'Missing query input',
            ]);
        }

        // Require at least 3 character inputs
        if (strlen($request->input('query')) < 3) {
            return response()->json([
                'products' => [],
            ]);
        }

        // Fetch products
        $ahProducts = AlbertHeijn::searchProducts($request->input('query'));
        $products = [];

        foreach($ahProducts as $product) {
            // Limit to 10 rows
            if (count($products) > 50) {
                break;
            }

            // Skip already existing items
            if (in_array($product->productomschrijving, $products)) {
                continue;
            }

            // Skip empty names
            if (strlen($product->productomschrijving) === 0) {
                continue;
            }

            $products[] = $product->productomschrijving . ' - ' . $product->recepttrefwoord;
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    public function postSearch(Request $request)
    {
        $ingredients = (array) Input::get('query');

        AlbertHeijn::setApiKey(env('API_KEY_ALBERTHEIJN'));
        dd(AlbertHeijn::searchRecipes('banaan'));

        $rating = array();
        $recipes = array();
        foreach($ingredients as $ingredient)
        {
            foreach(AlbertHeijn::searchRecipes($ingredient) as $recipe)
            {
                array_push($rating, $recipe->receptid);

                if(!isset($recipes[$recipe->receptid]))
                {
                    $recipes[$recipe->receptid] = $recipe;
                }
            }
        }

        if(!empty($rating))
        {
            $rating = array_count_values($rating);
        }


//        // $albertHeijn = new AlbertHeijn(env('API_KEY_ALBERTHEIJN'));
//        // $products = $albertHeijn->searchProducts('banaan');
//
//
//        AlbertHeijn::setApiKey(env('API_KEY_ALBERTHEIJN'));
//        dd(AlbertHeijn::searchRecipes('banaan'));
//
//        // dd($products);
//
//        // return response()->json([
//        //
//        // ]);
    }
}
