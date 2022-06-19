<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'ImageURL',
        'Link',
        'Title',
        'Description',
        'Clicks',
        'IsEnable',
        'Order'
    ];

    public static function BannerEnable($value = true,$limit=3,$where=null)
    {
        if(!$where){
            return Banner::query()->where('IsEnable',$value)
                ->orderByDesc('Order')->limit($limit)->get();
        }
        return Banner::query()->where('IsEnable',$value)
            ->orderByDesc('Order')->where($where)->limit($limit)->get();
    }
}
