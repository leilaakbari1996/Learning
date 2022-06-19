<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public static function GetSpecialProducts(Request $request)
    {
        return response()->json(["OK"]);

        if($request->wantsJson())
        {
            return response()->json([]);
        }

        return [];
    }

    public static function GetCategories(Request $request)
    {

    }
}
