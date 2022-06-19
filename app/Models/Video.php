<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'Title',
        'VideoURL',
        'Time',
        'Price',
        'IsFree',
        'video_title_id',
    ];
    /**public*/
    /***static*/
    public static function GetVideo($limit=5,$where=null)
    {
        if(!$where){
            return self::query()->where('IsEnable',true)->limit($limit);
        }
        return self::query()->where('IsEnable',true)->where($where)->limit($limit);
    }
    /**privet*/

    public static function GetVideosByOrders($orders,$limit=10,$where=null)
    {
        $ids = $orders->pluck('id')->all();

        if(!$where){
            return self::query()->whereHas('Order',function ($q) use ($ids){
                return  $q->where('orderable_type','App\Models\Video')->whereIn('course_order.order_id',$ids);
            })->limit($limit);
        }
        return self::query()->whereHas('Order',function ($q) use ($ids){
            return  $q->where('orderable_type','App\Models\Video')->whereIn('course_order.order_id',$ids);
        })->where('IsFree',true)->limit($limit);


    }

    public function UserCart()
    {
        return  $this->morphToMany(User::class,'cartable','carts');
    }

    public function Order()
    {
        return  $this->morphToMany(Order::class,'orderable','course_order');
    }
    /****end*/




}
