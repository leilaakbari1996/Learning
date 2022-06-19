<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Course extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'Title',
        'Description',
        'AfterBuyDescription',
        'Slug',
        'Price',
        'Discount',
        'Images',
        'Videos',
        'PreviewImageURl',
        'Type',
        'Order',
        'Views',
        'Likes',
        'TotalTime',
        'NumberOfBuys',
        'IsFree',
        'IsSpecial',
        'IsNew',
        'IsEnable',
        'Level',
        'Status',
        'UpdateDate',
        'FAQ',
        'SeoTitle',
        'SeoDescription',
        'Count'
    ];

    protected $casts = [
        "Value" => "array"
    ];

    /*********public**********/
    public function RelatedPodcasts($limit=5,$where=null)
    {
        if(!$where){
            return  $this->morphedByMany(Podcast::class,'relatedable','related_course')
                ->where('IsEnable',true)->orderByDesc('Order');
        }
        return  $this->morphedByMany(Podcast::class,'relatedable','related_course')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order');
    }

    public function RelatedPodcast($limit = 5)
    {
        $podcasts = $this->RelatedPodcasts()->limit($limit)->get();

        if($podcasts->count() < $limit){
            $l = $limit - $podcasts->count();
            $ids = $podcasts->pluck('id')->all();

            $podcastsRelated = Podcast::GetPodcast()->
            whereHas('RelatedPodcast',function ($q) use ($ids){
                return $q->whereIn('podcast_id',$ids);
            })->whereNotIn('podcasts.id',$ids)->limit($l)->get();
            $podcasts = $podcasts->merge($podcastsRelated);
        }
        return $podcasts;
    }

    public function RelatedCourses($limit=5,$where=null)
    {
        if(!$where){
            return  $this->morphedByMany(self::class,'relatedable','related_course')
                ->where('IsEnable',true)->orderByDesc('Order');
        }
        return  $this->morphedByMany(self::class,'relatedable','related_course')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order');
    }

    public function RelatedCourse($limit = 5,$where = null)
    {
        $courses = $this->RelatedCourses($limit,$where)->whereNotIn('courses.id',[$this->id])->
        limit($limit)->get();

        if($courses->count() < $limit){
            $categories = $this->Categories;
            return  self::RelatedCourseByCategory($courses,$categories,$limit,$this->id,$where);
        }

        return $courses;


    }

    public function RelatedGuidances($limit = 5, $where = null)
    {
        if(!$where){
            return  $this->morphedByMany(Guidance::class,'relatedable','related_course')
                ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
        }
        return  $this->morphedByMany(Guidance::class,'relatedable','related_course')
            ->where('IsEnable',true)->where($where)->orderByDesc('Order')->limit($limit);
    }

    public function RelatedBlog($limit = 10,$where=null)
    {
        if(!$where){
            return  $this->morphedByMany(Blog::class,'relatedable','related_course')
                ->where('IsEnable',true)->limit($limit);
        }
        return  $this->morphedByMany(Blog::class,'relatedable','related_course')
            ->where('IsEnable',true)->where($where)->limit($limit);
    }

    public function Order()
    {
        return  $this->morphToMany(Order::class,'orderable','course_order');
    }

    public function UsersCart()
    {
        return  $this->morphToMany(User::class,'cartable','carts')->withPivot('Count');
    }

    public function changeLike(User $user)
    {


        $like = $this->Likes;
        if ($user->LikedCourses()->where('likeable_id',$this->id)->exists())
        {
            $like--;
            $user->LikedCourses()->detach($this);

        }else{
            $like++;
            $user->LikedCourses()->attach($this);
        }

        $this->Likes = $like;
        $this->save();


    }

    public function changeSave(User $user)
    {
        if ($user->SaveCourses()->where('bookmarkable_id',$this->id)->exists())
        {
            $user->SaveCourses()->detach($this);

        }else{
            $user->SaveCourses()->attach($this);
        }
    }

    public function Comments()
    {

        return $this->morphMany(Comment::class,"commentable")->
        where('Status','Accepted');
    }

    public function Categories()
    {
        return $this->belongsToMany(CoursesCategory::class,'course_categories',
            'course_id','category_id')->
        where('IsEnable',true)->orderByDesc('Order');
    }

    public function CategoriesPanel()
    {
        return $this->belongsToMany(CoursesCategory::class,'course_categories',
            'course_id','category_id')->orderByDesc('Order');
    }

    public function BlogRelated($limit = 5)
    {
        return $this->belongsToMany(Blog::class,'courses_related_blog',
            'blog_id','course_id')->where('IsEnable',true)
            ->orderByDesc('Order')->limit($limit)->get();
    }

    public function Guidances()
    {
        return $this->belongsToMany(Guidance::class,'course_guidance',
            'course_id','guidance_id')->where('IsEnable',true)
            ->orderByDesc('Order');
    }

    public function Tags($limit=1000)
    {
        return  $this->morphToMany(Tag::class,'tagable','tag_all')->limit($limit);
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
        return  $this->SaveCourses()->where('user_id',$user->id)->exists();
    }

    public function CategoriesCourse()
    {
        return $this->belongsToMany(CoursesCategory::class,'course_categories',
            'course_id','category_id')->
        where('IsEnable',true)->orderByDesc('Order');
    }

    public function CategoriesCoursePanel()
    {
        return $this->belongsToMany(CoursesCategory::class,'course_categories',
            'course_id','category_id')->orderByDesc('Order');
    }

    public function VideosTitile()
    {
        return $this->hasMany(VideosTitle::class,'course_id')->orderByDesc('Order');
    }

    public function Masters()
    {
        return $this->belongsToMany(User::class,"course_user");
    }

    public function sluggable(): array
    {
        return [
            "Slug" => [
                "source" => "Title"
            ]
        ];
    }

    public function changeCountAndNumberOPfBuys()
    {
        $count = $this->Count;
        if($count != 0) {
            if ($count) {
                $count--;
            }
            $numberOfBuys = $this->NumberOfBuys;
            $numberOfBuys++;
            $result = $this->update([
                'Count' => $count,
                'NumberOfBuys' => $numberOfBuys
            ]);
            return $result;
        }
        return false;

    }

    /**********static********/


    public static function GetSpecialCourses($limit = 5)
    {
        return self::GetAllCoursesByEnable(true)->where('IsSpecial',true)->
        limit($limit)->get();
    }

    public static function GetCoursesByCategoryAndChilds($categories,$limit = 5,$where = null)
    {//Get Courses category and Courses ChildCategory
        $ids = $categories->pluck("id")->all();

        if ($where != null) {
            $courses = self::GetAllCoursesByEnable(true)->where($where)->whereHas('Categories', function ($q) use ($ids) {
                return $q->whereIn('course_categories.category_id', $ids);
            })->limit($limit)->get();
        } else {
            $courses = self::GetAllCoursesByEnable(true)->whereHas("Categories", function ($q) use ($ids) {
                return $q->whereIn("course_categories.category_id", $ids);
            })->limit($limit)->get();
        }
        return $courses;
    }

    public static function GetCourses($ids,$limit,$column = null)
    {
        if (!$column){
            return self::GetAllCoursesByEnable(true)->whereNotIn($ids)->limit($limit)->get();
        }
        return self::GetAllCoursesByEnable(true)->where($column,true)->whereNotIn('id',$ids)->limit($limit)->get();
    }

    public static function GetCoursesPanel($ids,$limit,$column = null)
    {
        if (!$column){
            return self::query()->whereNotIn($ids)->limit($limit)->get();
        }
        return self::query()->where($column,true)->whereNotIn('id',$ids)->limit($limit)->get();
    }

    public static function GetTheMostCourses($categories,$column,$limit = 5)
    {
        return self::RelatedCourseByCategoryMost(collect([]),$categories,$limit,$column);
    }

    public static function RelatedCourseByCategoryMost($relatedCourse,$categories,$limit = 5,$column = null)
    {
        $l = $limit - count($relatedCourse);

        if($l > $limit) return $relatedCourse;

        $ids = $categories->pluck("id")->all();

        $relatedCoursesIds = $relatedCourse->pluck("id")->all();

        if($column != null){
            $courses = self::GetAllCoursesByEnable(true)->whereHas('Categories',function ($q) use ($ids){
                return $q->whereIn('courses_categories.id',$ids);
            })->whereNotIn('id',$relatedCoursesIds)->orderByDesc($column)->limit($limit)->get();
        }else{
            $courses = self::GetAllCoursesByEnable(true)->whereHas("Categories",function($q) use ($ids){
                return $q->whereIn("courses_categories.id",$ids);
            })->whereNotIn("id",$relatedCoursesIds)->limit($l)->get();
        }

        $courses = $courses->merge($relatedCourse);
        $idsCourses = $courses->pluck('id')->all();

        if($courses->count() < 5){
            $array = self::GetAllCoursesByEnable(true)->whereNotIn('id',$idsCourses)->
            orderByDesc('Order')->orderByDesc($column)->limit(5-$courses->count())->get();

            return $courses->merge($array);
        }
        return $courses;
    }

    public static function GetCoursesByOrder($orders,$limit = 10,$where=null)
    {
        $ids = $orders->pluck('id')->all();
        if(!$where){
            return self::query()->whereHas('Order',function ($q) use ($ids){
                return  $q->where('orderable_type','App\Models\Course')->whereIn('course_order.order_id',$ids);
            })->limit($limit);
        }
        return self::query()->whereHas('Order',function ($q) use ($ids){
            return  $q->where('orderable_type','App\Models\Course')->whereIn('course_order.order_id',$ids);
        })->where($where)->limit($limit);

    }

    public static function GetMostCoursesByCategory(CoursesCategory $category,$limit = 5,$column=null)//Most Like,Most Discount,Most Buy,Most view
    {
        if(!$column){
            return $category->Courses()->where([
                'IsEnable' => true
            ])->orderByDesc('Order')->limit($limit)->get();
        }
        return $category->Courses()->where([
            'IsEnable' => true
        ])->orderByDesc('Order')->orderByDesc($column)->limit($limit)->get();
    }

    public static function GetCoursesByClick(CoursesCategory $category,$limit=5,$column = null)
    {//Courses This Category And Courses Childs
        if(!$column) $courses = self::GetCourcesByColum($category,$limit)->get();
        else $courses = self::GetCourcesByColum($category,$limit,[$column=>true])->get();
        $l = $limit - count($courses);

        if(count($courses) > $limit) return $courses;

        $categories = $category->Children;
        $relatedCoursesIds = $courses->pluck('id')->all();
        $ids = $categories->pluck('id')->all();

        if(!$column){
            $coursesRelated = self::GetAllCoursesByEnable(true)->whereHas("Categories",function($q) use ($ids){
                return $q->whereIn("courses_categories.id",$ids);
            })->whereNotIn("id",$ids)->limit($l)->get();
        }else {
            $coursesRelated = self::GetAllCoursesByEnable(true)->where($column, true)->whereHas("Categories", function ($q) use ($ids) {
                return $q->whereIn("courses_categories.id", $ids);
            })->whereNotIn("id", $ids)->limit($l)->get();
        }
        return $courses->merge($coursesRelated);
    }

    public static function GetCoursesTheMostByClick(CoursesCategory $category,$column = null,$limit=5)
    {
        $courses = self::GetMostCoursesByCategory($category,$column,$limit);
        $l = $limit - $courses->count();

        if($courses->count() > $limit) return $courses;

        $categories = $category->Children;
        $relatedCoursesIds = $courses->pluck('id')->all();
        $ids = $categories->pluck('id')->all();

        $coursesRelated = self::GetAllCoursesByEnable(true)->whereHas("Categories",function($q) use ($ids){
            return $q->whereIn("courses_categories.id",$ids);
        })->whereNotIn("id",$ids)->orderByDesc($column)->orderByDesc('Order')->limit($l)->get();
        return $courses->merge($coursesRelated);
    }

    public static function GetAllCoursesByEnable($value=true,$where = null)
    {
        if(!$where){
            return self::query()->where('IsEnable',$value)->orderByDesc('Order');
        }
        return self::query()->where('IsEnable',$value)->where($where)->orderByDesc('Order');
    }
    /************privet***************/


/*****End******/

    private static function GetCourcesByColum(CoursesCategory $category ,$limit = 10,$where = null)//Free,Special,New,Status,Level,Type
    {

        if(!$where)
        {
            return $category->Courses()->where([
                ['IsEnable',true]
            ])->orderByDesc('Order')->limit($limit);
        }

        return $category->Courses()->where("IsEnable",true)->where($where)->orderByDesc('Order')
            ->limit($limit);

    }

    public static function GetAllCourse($categories,$limit = 5,$column = null)
    {
        if(!$column){
            return self::RelatedCourseByCategory(collect([]),$categories,$limit);
        }
        return self::RelatedCourseByCategory(collect([]),$categories,$limit,[$column => true]);

    }

    public static function RelatedCourseByCategory($relatedCourse,$categories,$limit = 5,$id = 0,$where = null)
    {
        $l = $limit - count($relatedCourse);
        $relatedCoursesIds = $relatedCourse->pluck("id")->all();
        if ($id != 0) {
            $relatedCoursesIds[] = $id;
        }

        if(count($relatedCourse) > $limit) return $relatedCourse;

        $ids = $categories->pluck("id")->all();

        if($where != null){
            $courses = self::GetAllCoursesByEnable(true)->where($where)->whereHas('Categories',function ($q) use ($ids){
                return $q->whereIn('courses_categories.id',$ids);
            })->whereNotIn('id',$relatedCoursesIds)->limit($limit)->get();
        }else{
            $courses = self::GetAllCoursesByEnable(true)->whereHas("Categories",function($q) use ($ids){
                return $q->whereIn("courses_categories.id",$ids);
            })->whereNotIn("id",$relatedCoursesIds)->limit($l)->get();
        }

        $courses = $courses->merge($relatedCourse);
        $idsCourses = $courses->pluck('id')->all();

        if($courses->count() < 5){
            $array = self::GetAllCoursesByEnable(true)->where($where)->whereNotIn('id',$idsCourses)->
            orderByDesc('Order')->whereNotIn("id",$relatedCoursesIds)->limit(5-$courses->count())->get();

            return $courses->merge($array);
        }
        return $courses;
    }

    public static function Related(CoursesCategory $category,$collect,$limit,$relatedCourse)
    {
        $courses = $category->Courses;

        $count = $courses->count();

        if ($count > $limit) return $courses->limit($limit)->get();
        $limit -= $count;
        $collect = $collect->merge($courses);
        $parents = CoursesCategory::Parents([],$category);
        foreach ($parents as $category)
        {
            if(!$collect->contains(self::Related($category,$collect,$limit))){
                return $collect = $collect->merge(self::Related($category, $collect, $limit));
            }
        }

    }

    public function GetCourseByColumn($colum,$value)//By Slug,By SeoTitle,By SeoDesc
    {
        return self::GetAllCoursesByEnable(true)->where($colum,$value)->orderByDesc('Order')->first();
    }

    public static function GetCourseBySlug($slug)//Get Course
    {
        $course = self::query()->where(
            [
                'Slug' => $slug,
                'IsEnable' => true
            ])

        ->first();

       return $course;
    }

    public static function GetCoursesFree()
    {
        return self::GetAllCoursesByEnable(true)->where('IsFree',true)->orderByDesc('Order');
    }

    public static function GetNewCourses(CoursesCategory $category,$limit=5)
    {
        $courses = self::GetCourcesByColum($category,$limit,["IsNew"=>true])->get();
        $l = $limit - count($courses);

        if($l > $limit) return $courses;
        $categories = [];

        $categories = $category->Children;
        $relatedCoursesIds = $courses->pluck('id')->all();
        $ids = $categories->pluck('id')->all();
        $coursesNew = self::GetCoursesNew()->whereHas("Categories",function($q) use ($ids){
            return $q->whereIn("courses_categories.id",$ids);
        })->whereNotIn("id",$ids)->limit($l)->get();
        return $courses->merge($coursesNew);
    }

    public static function GetMostCourses(CoursesCategory $category,$limit=10,$column=null)
    {
        $courses = $category->Courses()->where([
            'IsEnable' => true
        ])->orderByDesc('Order')->orderByDesc($column)->limit($limit)->get();
        $l = $limit - count($courses);

        if($l > $limit) return $courses;
        $categories = [];

        $categories = $category->Children;
        $relatedCoursesIds = $courses->pluck('id')->all();
        $ids = $categories->pluck('id')->all();
        $coursesMost = self::GetMost($column,$l)->whereHas("Categories",function($q) use ($ids){
            return $q->whereIn("courses_categories.id",$ids);
        })->whereNotIn("id",$relatedCoursesIds)->limit($l)->get();
        return $courses->merge($coursesMost);
    }

    public static function GetFreeCourses(CoursesCategory $category,$limit = 5)
    {

        $courses = self::GetCourcesByColum($category,$limit,['IsFree'=>true])->get();

        $l = $limit - count($courses);

        if($l > $limit) return $courses;
        $categories = [];

        $categories = $category->Children;

        $relatedCoursesIds = $courses->pluck('id')->all();

        $ids = $categories->pluck('id')->all();

        $coursesNew = self::GetCoursesFree()->whereHas("Categories",function($q) use ($ids){
            return $q->whereIn("courses_categories.id",$ids);
        })->whereNotIn("id",$ids)->limit($l)->get();
        return $courses->merge($coursesNew);
    }

    public static function GetFreeCources(CoursesCategory $category,$limit = 10)
    {
        return self::GetCourcesByColum($category,['IsFree'=>true],$limit);
    }

    public static function GetCoursesNew()
    {
        return self::GetAllCoursesByEnable(true)->where('IsNew',true);
    }

    public static function GetMost($column,$limit = 5)
    {
        return self::GetAllCoursesByEnable(true)->orderByDesc($column)->limit($limit);
    }

    public static function GetIsSpecialCources(CoursesCategory $category,$limit=10)
    {
        return self::GetCourcesByColum($category,[
            "IsSpecial" => true,
        ],$limit);
    }

    public  static  function GetCourcessBySlugCategory($slug, $limit = 10,$where="1=1",$orderBy="created_at DESC"){//category

        $category = self::GetCategoryBySlug($slug);
        $ids = [];
        $ids[] = $category->id;
        $arrayIds = self::GetIds($ids,$category);
        return Product::query()->whereRaw($where)/*->with("categories")*/->whereHas("categories",function($cat) use ($arrayIds){
            $cat->whereIn("categories.id",$arrayIds);
        })->orderByRaw($orderBy)
        ->paginate($limit);
    }

    public static function GetCourcesByStatus(CoursesCategory $category,$status,$limit=10)//ok
    {
        return self::GetCourcesByColum($category,["Status"=>$status],$limit);
    }

    public static function GetIsNewCources(CoursesCategory $category,$limit=10)//ok
    {
        return self::GetCourcesByColum($category,["IsNew"=>true],$limit);
    }


}
