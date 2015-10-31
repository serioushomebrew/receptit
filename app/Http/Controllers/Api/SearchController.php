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

            // Skip products which doesnt contains any joule's
            if (!isset($product->joule))
            {
                continue;
            }

            // Find the product name
            $productname = '';
            foreach(explode(' ', $product->productomschrijving) as $name)
                if (strpos($name, $request->input('query')) !== false &&
                    strpos($name, '-') === false &&
                    strpos($name, '/') === false &&
                    strpos($name, '&') === false &&
                    strpos($name, '.') === false)
                    $productname = strtolower($name);

            // Skip already existing items
            if (in_array($productname, $products)) {
                continue;
            }

            // Skip empty names
            if (strlen($productname) === 0) {
                continue;
            }

            $products[] = $productname;
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
