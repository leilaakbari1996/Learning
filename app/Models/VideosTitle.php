<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class VideosTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'Title',
        'Order',
        'parent_id',
        'course_id',
        'IsEnable'
    ];
/*****public*/
    public function Videos($limit=10)
    {
        return $this->hasMany(Video::class,'video_title_id')->where('IsEnable',true)->
        limit($limit);
    }
    /***static***/
    public static function GetVideoTitle(Course $course,$where=null)
    {
        if(!$where){
            return  self::query()->where([
                'IsEnable'=> true,
                'course_id' => $course->id
            ]);
        }
        return self::query()->where([
                'IsEnable'=> true,
                'course_id' => $course->id
            ])->where($where);
    }
    /**privet**/
    /**end*/
}
