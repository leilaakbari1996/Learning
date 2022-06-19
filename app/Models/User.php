<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'FirstName',
        'LastName',
        'PhoneNumber',
        'Email',
        'remember_token',
        'IsAdmin',
        'IsMaster',
        'Wallet',
        'ProfileURL',
        'IsEnable'
    ];

    /***public*/

    public function Coupons()
    {
        return $this->belongsToMany(Coupon::class,'coupon_user','user_id',
            'coupon_id');
    }

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }

    public function LikedCourses()
    {
        return $this->morphedByMany(Course::class,"likeable","like");
    }

    public function SaveCourses()
    {
        return  $this->morphedByMany(Course::class,'bookmarkable','bookmarks');
    }

    public function LikedPodcast()
    {
        return $this->morphedByMany(Podcast::class,"likeable","like");
    }

    public function SavePodcast()
    {
        return  $this->morphedByMany(Podcast::class,'bookmarkable','bookmarks');
    }

    public function LikedBlog()
    {
        return $this->morphedByMany(Blog::class,"likeable","like");
    }

    public function SaveBlog()
    {
        return  $this->morphedByMany(Blog::class,'bookmarkable','bookmarks');
    }

    public function CoursesInCart()
    {
        return $this->morphedByMany(Course::class,'cartable','carts')->withPivot('Count');
    }

    public function VideosInCart()
    {
        return $this->morphedByMany(Video::class,'cartable','carts')->withPivot('Count');
    }

    public function checkExistsCourse($id)
    {
        return $this->CoursesInCart()->where('cartable_id',$id)->exists();
    }

    public function checkExistsVideo($id)
    {
        return $this->VideosInCart()->where('cartable_id',$id)->exists();
    }

    public function Courses()
    {
        return $this->morphedByMany(Course::class,'orderable','course_order');
    }

    public function Videos()
    {
        return $this->morphedByMany(Video::class,'orderable','course_order');
    }

    public function LikePodcat()
    {

        return $this->morphToMany(Podcast::class,'likeable','like','user_id',
            'likeable_id');
    }

    public function CoursesByMaster()
    {
        if($this->IsMaster)
        {
            return $this->belongsToMany(Course::class,'course_user','user_id'
            ,'course_id');
        }
    }


    /**static*/


    public static function GetUsersByRole($limit=10,$where=null)//Get User according to Role=admin or master
    {
        if (!$where)
        {
            return self::query()->limit($limit);
        }
        return  User::query()->where($where)->limit($limit);
    }
    /**privet*/
    /**end*/

    public static function GetUsersByOrders($orders)
    {
        $ids = $orders->pluck('id')->all();

        $users = User::query()->whereHas('Orders',function ($q) use ($ids){
            return  $q->whereIn('id',$ids);
        })->get();
        return $users;
    }







}
