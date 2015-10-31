<?php

namespace App\Http\Controllers\Api;

use App\Library\AlbertHeijn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function postSearch(Request $request)
    {


        // $albertHeijn = new AlbertHeijn(env('API_KEY_ALBERTHEIJN'));
        // $products = $albertHeijn->searchProducts('banaan');


        AlbertHeijn::setApiKey(env('API_KEY_ALBERTHEIJN'));
        dd(AlbertHeijn::searchRecipes('banaan'));

        // dd($products);

        // return response()->json([
        //
        // ]);



    }
}
