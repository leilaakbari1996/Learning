<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guidance extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'Title',
        'Description',
        'Order',
        'Slug',
        'IconURL',
        'ImageURL',
        'VideoURL',
        'IsEnable',
        'IsSpecial'
    ];

    /********public********/
    public function sluggable(): array
    {
        return [
            "Slug" => [
                "source" => "Title"
            ]
        ];
    }

    public function RelatedPodcasts($limit = 5,$where = null)
    {
        if(!$where) {
            return $this->morphedByMany(Podcast::class, 'relatedable', 'related_guidance')
                ->where('IsEnable', true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Podcast::class,'relatedable','related_guidance')
            ->where('IsEnable',true)->orderByDesc('Order')->where($where)->limit($limit);
    }

    public function RelatedCourses($limit=5,$where = null)
    {
        if(!$where) {
            return $this->morphedByMany(Course::class, 'relatedable', 'related_guidance')
                ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Course::class,'relatedable','related_guidance')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function RelatedGuidances($limit=5,$where = null)
    {
        if(!$where) {
            return $this->morphedByMany(self::class, 'relatedable', 'related_guidance')
                ->where('IsEnable', true)->orderByDesc('Order')->whereNotIn('guidances.id',[$this->id])->
                limit($limit);
        }
        return  $this->morphedByMany(self::class,'relatedable','related_guidance')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->
            whereNotIn('guidances.id',[$this->id])->limit($limit);
    }
    /*
     * public function RelatedGuidance($limit=5,$where = null)
    {
        if(!$where){
            return $this->belongsToMany(Guidance::class,'guidance_related','guidance_id',
                'guidance_related_id')->whereNotIn('guidances.id',[$this->id])->limit($limit);
        }
        return $this->belongsToMany(Guidance::class,'guidance_related','guidance_id','
        guidance_related_id')->where('IsEnable',true)->where($where)->
        whereNotIn('guidances.id',[$this->id])->limit($limit);
    }*/

    public function RelatedBlog($limit=5,$where = null)
    {
        if(!$where) {
            return  $this->morphedByMany(Blog::class,'relatedable','related_guidance')
                ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Blog::class,'relatedable','related_guidance')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function Courses($limit = 5)
    {
        return $this->belongsToMany(Course::class,'course_guidance',
            'guidance_id','course_id')
            ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
    }


    /*******static***/
    public static function GetGuidence($limit = 5,$where = null)//Get Blogs Enable according where
    {
        if(!$where)
        {
            return self::query()->where('IsEnable',true)->orderByDesc('Order');
        }
        return self::query()->where('IsEnable',true)->where($where)->orderByDesc('Order');
    }
    /*****privet**/







    /******End*/


}
