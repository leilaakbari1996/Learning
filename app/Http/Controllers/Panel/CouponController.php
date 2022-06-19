<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use \App\Http\Requests\Panel\CouponRequest as CouponPanel;

class CouponController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست کوپن ها');

        $coupons = Coupon::Coupons(10);

        return view('panel.coupon.index',compact('coupons'));
    }

    public function show(Coupon $coupon)
    {
        \Head::SetTitle('Coupon');

        return view('panel.coupon.show',compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        \Head::SetTitle('edit Coupon');

        return view('panel.coupon.edit',compact('coupon'));
    }

    public function create()
    {
        \Head::SetTitle('ایجاد کد تخفیف');

        return view('panel.coupon.create');
    }

    public function store(CouponPanel $request)
    {
        $validataData = $request->validated();

        $coupon = Coupon::create($validataData);

        $response = [
            'status' => 1,
            'data' => 'Coupon saved successfully',
            'text' => $coupon
        ];

        return $response;
    }

    public function update(Coupon $coupon,CouponPanel $request)
    {
        $validataData = $request->validated();

        $coupon->update($validataData);

        $response = [
            'status' => 1,
            'data' => 'Coupon saved successfully',
            'text' => $coupon
        ];

        return $response;
    }




}
