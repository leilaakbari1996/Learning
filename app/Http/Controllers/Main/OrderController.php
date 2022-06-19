<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Requests\OrderRequest;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\OrderController as OrderApi;
use \App\Http\Controllers\Api\CartController as CartApi;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $courses = $user->CoursesInCart;
        $videos = $user->VideosInCart;

        return view('client.order',compact('courses','videos','user'));
    }



    public function destroyAll(Request $request)
    {
        $user = auth()->user();
        OrderApi::DestroyAll($request,$user);
    }
}
