<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'Count',
        'Type',
        'Amount',
        'MinOrder',
        'StartDate',
        'EndDate',
        'IsEnable',
        'Title'
    ];

    /**public**/
    public function Users()
    {
        return $this->belongsToMany(User::class,'coupon_user');
    }

    /***static**/
    public static function Coupons($limit=10,$where=null)
    {
        if(!$where){
            return self::all();
        }
        return self::query()->where($where)->limit($limit);
    }
    public static function GetCoupon($array)
    {
        $user = auth()->user();
        $coupon = self::query()->where([
            'IsEnable' => true,
            'Title' => $array['coupon'],

        ])->where('Count','>',0)->where('MinOrder','<',$array['price'])
            ->first();



            if ($coupon) {
                $isExists = $user->Coupons()->where('Title',$coupon->Title)->exists();
                if(!$isExists) {
                    $currentDate = date('Y-m-d');
                    $currentDate = date('Y-m-d', strtotime($currentDate));
                    if(!$coupon->StartDate){
                        $startDate = $coupon->StartDate;
                    }else {
                        $startDate = date('Y-m-d', strtotime($coupon->StartDate));
                    }
                    if(!$coupon->EndDate) {
                        $endDate = $coupon->EndDate;
                    }else{
                        $endDate = date('Y-m-d', strtotime($coupon->EndDate));
                    }
                    if (($startDate == null || $currentDate >= $startDate) && ($endDate == null ||($currentDate <= $endDate))) {
                        $user->Coupons()->attach($coupon);
                        return $coupon;
                    }else return 'تاریخ این کوپن تمام شده است.';
                }
                else return 'این کوپن قبلا توسط شما استفاده شده';
            }
            return 'کوپن موجود نیست.';

    }

    public static function changeCount($couponId)//change Count--
    {
        $coupon = self::query()->where('id',$couponId)->first();
        $count = $coupon->Count;
        $count --;
        $coupon->update([
            'Count' => $count
        ]);
    }

    /**privet*/
}
