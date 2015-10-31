<?php

namespace App\Http\Controllers\Api;

use App\Library\AlbertHeijn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Input;

use App\ProductTag;

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

        $products = [];
        $tags = ProductTag::where('query', $request->input('query'))
            ->take(env('LIVESEARCH_PRODUCT_TAGS_LIMIT', 10))
            ->get();

        if (count($tags) > 0) {
            foreach($tags as $tag) {
                $products[] = $tag->tag;
            }
        } else {
            // Fetch products
            $ahProducts = AlbertHeijn::searchProducts($request->input('query'));

            // Dont search if there arent any products available
            if (count($ahProducts) === 0) {
                return response()->json([
                    'products' => $products,
                ]);
            }

            foreach ($ahProducts as $product) {
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

                // Save it in the database
                ProductTag::create([
                    'query' => $request->input('query'),
                    'tag' => $productname,
                ]);

                if (count($products) <= env('LIVESEARCH_PRODUCT_TAGS_LIMIT', 10)) {
                    $products[] = $productname;
                }
            }
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    public function postSearchRecipes(Request $request)
    {
        AlbertHeijn::setApiKey(env('API_KEY_ALBERTHEIJN'));

        $products = $request->json()->get('products');

        $recipes = AlbertHeijn::searchRecipes($products);

        dd($recipes);
    }

    public function postSearch(Request $request)
    {
        AlbertHeijn::setApiKey(env('API_KEY_ALBERTHEIJN'));

        // Require a query string in order to continue
        if (!$request->has('query')) {
            return response()->json([
                'error' => 'Missing query input',
            ]);
        }

        $rating = [];
        $recipes = [];
        $ordered = [];

        // go through each ingredient
        $ingredients = (array) $request->input('query');
        foreach ($ingredients as $ingredient) {

            // Require at least 3 character inputs
            if (strlen($ingredient) >= 3) {
                // Get recipes with this ingredient
                $ahRecipes = AlbertHeijn::searchRecipes($ingredient);

                if(!empty($ahRecipes)) {
                    foreach($ahRecipes as $recipe) {
                        // check if result is valid
                        if($recipe->querystatus == 0) {
                            continue;
                        }

                        // add the receptid to the rating
                        array_push($rating, $recipe->receptid);

                        // save the recipe to an array
                        if (!isset($recipes[$recipe->receptid])) {
                            $recipes[$recipe->receptid] = $recipe;
                        }
                    }
                }
            }
        }

        // if we got any results to rate
        if (!empty($rating)) {
            $rating = array_count_values($rating);
            arsort($rating);
            $rating = array_slice($rating, 0, 6, true);

            foreach($rating as $recipe_id => $count) {
                array_push($ordered, $recipes[$recipe_id]);
            }
            unset($recipes);
        }

        return response()->json([
            'recipes' => $ordered,
        ]);
    }
}
