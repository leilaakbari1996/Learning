<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\OrderController as OrderApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $validateData = $request->validated();
        $user = auth()->user();

        $courses = $user->CoursesInCart;
        $videos = $user->VideosInCart;
        $totalPrice = computing($courses,'Price') + computing($videos,'Price');
        $discount = computing($courses,'Discount') + computing($videos,'Discount');
        $totalPriceWithDiscount = $totalPrice - $discount;
        $validateData['Discount'] = $discount;
        $validateData['user_id'] = $user->id;
        $validateData = delete_add_validateData($validateData,'TotalPrice',$validateData['price']);

        $order = Order::create($validateData);

        if($validateData['couponId']) {
            Coupon::changeCount($validateData['couponId']);
        }

        foreach ($courses as $course){
            $result = $course->changeCountAndNumberOPfBuys();
            if($result) {
                $order->Courses()->attach($course, [
                    'Count' => $course->pivot->Count,
                    'Discount' => $course->Discount,
                    'Price' => $course->Price,
                ]);

            }
        }
        foreach ($videos as $video){
            $order->Videos()->attach($video,[
                'Count' => $video->pivot->Count,
                'Price' => $video->Price,
                'Discount' => 0
            ]);
        }

        $user->CoursesInCart()->detach();
        $user->VideosInCart()->detach();

        $response = [
            'status' => 1,
            'text' => 'add to order',
            'data' => $order
        ];

        return $response;
    }

    public static function Destroy(Request $request)
    {
        $user = auth()->user();

        $validateData = $request->validate([
            'model' => 'required|in:Course,Podcast,Blog',
            'id' => 'required|integer'
        ]);

        if($validateData['model'] == 'Course'){
            $isExists = $user->checkExistsCourse($validateData['id']);
            if($isExists){
                $user->CoursesInCart()->detach($validateData['id'],['Count' => $validateData['count']]
                );
            }else{
                abort(403);
            }

        }else if($validateData['model'] == 'Video'){
            $isExists = $user->checkExistsVideo($validateData['id']);
            if($isExists){
                $user->VideosInCart()->detach($validateData['id']);
            }else{
                abort(403);
            }
        }

        $response = [
            'status' => 1,
            'text' => "succsfull",

        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function DestroyAll(Request $request,User $user)
    {
        if(!$request->get('model')){
            $user->CoursesInCart()->detach();
            $user->VideosInCart()->detach();
        }else {
            if ($request->get('model') == 'Course') {
                $user->CoursesInCart()->detach();
            } else if ($request->get('model') == 'Video') {
                $user->VideosInCart()->detach();

            }
        }
        $response = [
            'status' => 1,
            'text' => "succsfull",
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;

    }
}
