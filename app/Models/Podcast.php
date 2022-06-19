<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'Title',
        'Description',
        'Slug',
        'AudioURl',
        'ImageURL',
        'ThumbnailURl',
        'IsEnable',
        'IsNew',
        'IsSpecial',
        'Order',
        'SeoTitle',
        'SeoDescription',
    ];
    /****public*/
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
            return $this->morphedByMany(Podcast::class, 'relatedable', 'related_podcast')
                ->where('IsEnable', true)->whereNotIn('podcasts.id',[$this->id])->
                orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Podcast::class,'relatedable','related_podcast')
            ->where('IsEnable',true)->whereNotIn('podcasts.id',[$this->id])->
            orderByDesc('Order')->where($where)->limit($limit);
    }
    /*public function PodcastRelated($limit=5,$where = null)
    {
        if(!$where){
            return $this->belongsToMany(self::class,'podcast_related',
                'podcast_id','podcast_related_id')
                ->where('IsEnable',true)->orderByDesc('Order');
        }
        return $this->belongsToMany(self::class,'podcast_related',
            'podcast_id','podcast_related_id')->where($where)
            ->where('IsEnable',true)->orderByDesc('Order');
    }*/

    public function RelatedCourses($limit=5,$where = null)
    {
        if(!$where) {
            return $this->morphedByMany(Course::class, 'relatedable', 'related_podcast')
                ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Course::class,'relatedable','related_podcast')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->limit($limit);
    }
    /*public function RelatedCoursesPodcast($limit = 5,$where = null)
    {
        if ($this->IsEnable)
        {
            if(!$where){
                $courses = $this->belongsToMany(Course::class,'courses_related_podcast',
                    'podcast_id','course_id')->where('IsEnable',true)
                    ->orderByDesc('Order')->get();
            }else{
                $courses = $this->belongsToMany(Course::class,'courses_related_podcast',
                    'podcast_id','course_id')->where('IsEnable',true)->where($where)
                    ->orderByDesc('Order')->get();
            }
            return $courses;

        }
    }*/

    public function RelatedGuidances($limit=5,$where = null)
    {
        if(!$where) {
            return $this->morphedByMany(Guidance::class, 'relatedable', 'related_podcast')
                ->where('IsEnable', true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Guidance::class,'relatedable','related_podcast')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function RelatedBlog($limit=5,$where = null)
    {
        if(!$where) {
            return  $this->morphedByMany(Blog::class,'relatedable','related_podcast')
                ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Blog::class,'relatedable','related_podcast')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->limit($limit);
    }

    /*public function PodcastRelated($limit=5,$where = null)
    {
        if(!$where){
            return $this->belongsToMany(self::class,'podcast_related',
                'podcast_id','podcast_related_id')
                ->where('IsEnable',true)->orderByDesc('Order');
        }
        return $this->belongsToMany(self::class,'podcast_related',
            'podcast_id','podcast_related_id')->where($where)
            ->where('IsEnable',true)->orderByDesc('Order');
    }*/

    public function Tags()
    {
        return  $this->morphToMany(Tag::class,'tagable','tag_all');
    }





    public function Comments()
    {
        return $this->morphMany(Comment::class,"commentable");
    }

    public function RelatedPodcast($limit = 5,$where = null)
    {
        if(!$where){
            return $this->belongsToMany(self::class,'podcast_related',
                'podcast_related_id','podcast_id')
                ->where('IsEnable',true)->orderByDesc('Order');
        }
        return $this->belongsToMany(self::class,'podcast_related',
            'podcast_related_id','podcast_id')->where($where)
            ->where('IsEnable',true)->orderByDesc('Order');
    }

    public function CoursesRelated()
    {
        return  $this->belongsToMany(Course::class,'courses_related_podcasts',
            'podcast_id','course_id')->
        where('IsEnable',true)->orderByDesc('Order');
    }

    public function UserLiked()
    {
        return  $this->morphToMany(User::class,'likeable','like');
    }

    public function changeLike(User $user)
    {


        $like = $this->Likes;
        if ($user->LikePodcat()->where('likeable_id',$this->id)->exists())
        {
            $like--;
            $user->LikePodcat()->detach($this);

        }else{
            $like++;
            $user->LikePodcat()->attach($this);
        }

        $this->Likes = $like;
        $this->save();


    }

    public function changeSave(User $user)
    {
        if ($user->SavePodcast()->where('bookmarkable_id',$this->id)->exists())
        {
            $user->SavePodcast()->detach($this);

        }else{
            $user->SavePodcast()->attach($this);
        }
    }

    public function isLiked(User $user)
    {
        return $this->UserLiked()->where("user_id",$user->id)->exists();
    }

    public function isSave(User $user)
    {
        return  $this->Savecourses()->where('user_id',$user->id)->exists();
    }

    /***static*/
    public static function GetPodcast($limit = 10,$where = null)//Get Podcasts Enable according to where
    {

        if(!$where)
        {
            return self::query()->where('IsEnable',true)->orderByDesc('Order');
        }
        return  self::query()->where('IsEnable',true)->where($where)->orderByDesc('Order');
    }


    /****privet**/







}
