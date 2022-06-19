<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("getCourses",[\App\Http\Controllers\Api\HomeController::class,"GetSpecialProducts"]);

Route::post("saveCourse",function(Request $request){
    if($request->wantsJson())
    {
        return response()->json([
            $request->all()
        ]);
    }

    return  response([
        $request->all()
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});