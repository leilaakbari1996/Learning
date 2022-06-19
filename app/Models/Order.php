<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'Status',
        'TotalPrice',
        'Discount',
        'Email',
        'PhoneNumber',
        'user_id',
        'coupon_id',
    ];
    public function Courses()
    {
        return $this->morphedByMany(Course::class,'orderable','course_order');
    }

    public function Videos()
    {
        return  $this->morphedByMany(Video::class,'orderable','course_order');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    /**end*/





}
