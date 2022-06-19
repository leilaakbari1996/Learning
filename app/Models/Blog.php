<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'Title',
        'Text',
        'ImageURl',
        'ThumbnailURl',
        'Views',
        'Save',
        'Like',
        'Order',
        'Slug',
        'IsNew',
        'IsEnable',
        'SeoTitle',
        'SeoDescription',
        'author_id',
        'IsEnable'
    ];

    /**public*/
    public function sluggable(): array
    {
        return [
            "Slug" => [
                "source" => "Title"
            ]
        ];
    }

    public function CoursesRelated($limit = 5,$where = null)
    {
        if ($this->IsEnable)
        {
            $courses = $this->RelatedCourses($limit,$where)->get();
                /*$this->belongsToMany(Course::class,'courses_related_blog',
                'blog_id','course_id')->where('IsEnable',true)
                ->orderByDesc('Order')->limit($limit)->get();*/

            if($courses->count() < $limit) {
                $categories = $this->Categories;
                $ids = $categories->pluck('id')->all();
                $l = $limit - count($courses);
                $relatedCoursesIds = $courses->pluck('id')->all();

                $blogRelated = self::GetBlogs(1000)->whereHas('Categories', function ($q) use ($ids) {
                    return $q->whereIn('blog_category.category_id', $ids);
                })->get();

                $idRelated = $blogRelated->pluck('id')->all();
                $shom = $blogRelated->count();
                $coursesRelated = Course::query()->where('IsEnable',true)->
                whereHas('RelatedBlog', function ($q) use ($idRelated) {
                    return $q->whereIn('relatedable_id', $idRelated);
                })->whereNotIn('id', $relatedCoursesIds)->limit($l-$shom)->get();
                $courses = $courses->merge($coursesRelated);

            }
            return $courses;

        }
    }

    public function Tags($limit=4)
    {
        return  $this->morphToMany(Tag::class,'tagable','tag_all')->limit($limit);
    }

    public function RelatedPodcasts($limit = 5,$where = null)
    {//->where('IsEnable', true)
        if(!$where) {
            return $this->morphedByMany(Podcast::class, 'relatedable', 'related_blog')
                ->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Podcast::class,'relatedable','related_blog')
           ->orderByDesc('Order')->where($where)->limit($limit);
    }

    public function RelatedCourses($limit=5,$where = null)
    {//->where('IsEnable', true)
        if(!$where) {
            return $this->morphedByMany(Course::class, 'relatedable', 'related_blog')
                ->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Course::class,'relatedable','related_blog')
           ->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function RelatedGuidances($limit=5,$where = null)
    {//->where('IsEnable', true)
        if(!$where) {
            return $this->morphedByMany(Guidance::class, 'relatedable', 'related_blog')
                ->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Guidance::class,'relatedable','related_blog')
            ->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function RelatedBlog($limit=5,$where = null)
    {//->where('IsEnable', true)
        if(!$where) {
            return  $this->morphedByMany(Blog::class,'relatedable','related_blog')
                ->orderByDesc('Order')->whereNotIn('blogs.id',[$this->id])->limit($limit);
        }
        return  $this->morphedByMany(Blog::class,'relatedable','related_blog')
            ->where($where)->orderByDesc('Order')->whereNotIn('blogs.id',[$this->id])->limit($limit);
    }

    public function changeLike(User $user)
    {


        $like = $this->Likes;
        if ($user->LikedBlog()->where('likeable_id',$this->id)->exists())
        {
            $like--;
            $user->LikedBlog()->detach($this);

        }else{
            $like++;
            $user->LikedBlog()->attach($this);
        }

        $this->Likes = $like;
        $this->save();


    }

    public function changeSave(User $user)
    {
        if ($user->SaveBlog()->where('bookmarkable_id',$this->id)->exists())
        {
            $user->SaveBlog()->detach($this);

        }else{
            $user->SaveBlog()->attach($this);
        }
    }

    public function Comments()
    {
        return $this->morphMany(Comment::class,"commentable");
    }

    public function UserLiked()
    {
        return  $this->morphToMany(User::class,'likeable','like');
    }

    public function isLiked(User $user)
    {
        return $this->UserLiked()->where("user_id",$user->id)->exists();
    }

    public function isSave(User $user)
    {
        return  $this->Savecourses()->where('user_id',$user->id)->exists();
    }

    public function Categories()
    {
        return $this->belongsToMany(BlogCategory::class,'blog_category',
            'blog_id','category_id')->
        where('IsEnable',true)->orderByDesc('Order');
    }
    public function CategoriesPanel()
    {
        return $this->belongsToMany(BlogCategory::class,'blog_category',
            'blog_id','category_id')->orderByDesc('Order');
    }


    /**static*/
    public static function GetBlogs($limit = 5,$where=null)
    {
        if(!$where){
            return self::query()->where('IsEnable',true)->orderByDesc('Order')
                ->limit($limit);
        }
        return self::query()->where('IsEnable',true)
            ->where($where)->orderByDesc('Order')->limit($limit);
    }

    public static function GetBlogsPanel($limit = 5,$where=null)
    {
        if(!$where){
            return self::query()->orderByDesc('Order')
                ->limit($limit);
        }
        return self::query()->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function BlogRelated($limit = 5,$where = null)
    {
        return $this->belongsToMany(self::class,'blog_related',
            'blog_id','blog_related_id')
            ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
    }

    /**privet**/

   /***end*/



    public static function BlogNew($limit = 5)
    {
        return self::GetBlogsIsEnable(true)->where('IsNew',true)->orderByDesc('Order')
            ->paginate($limit);
    }

    public static function GetBlogByCategory(BlogCategory $category,$where = null,$limit = 10)
    {
        if(!$where){
            return $category->Blogs()->where('IsEnable',true)->orderByDesc('Order')
                ->paginate($limit);
        }
        return $category->Blogs()->where('IsEnable',true)
            ->where($where)->orderByDesc('Order')->paginate($limit);

    }

}
