<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public static function Coupon(CouponRequest $request)
    {
        $validateData = $request->validated();
        $result = Coupon::GetCoupon($validateData);
        if(is_string($result)){
            $response = [
                'status' => 0,
                'text' => "Fail",
                'data' => $result
            ];
        }else{
            $response = [
                'status' => 1,
                'text' => "کوپن با موفقیت اعمال شد.",
                'data' => $result
            ];
        }



        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
}
