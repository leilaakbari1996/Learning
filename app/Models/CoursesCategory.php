<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesCategory extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'Title',
        'Slug',
        'Order',
        'parent_id',
        'IsEnable',
        'IsSpecial'
    ];

    /****************public******/
    public function sluggable(): array
    {
        return [
            "Slug" => [
                "source" => "Title"
            ]
        ];
    }

    public function Children()
    {
        return $this->hasMany(self::class,'parent_id','id')
            ->where('IsEnable',true)->orderByDesc('Order');
    }

    public function ChildrenPanel()
    {
        return $this->hasMany(self::class,'parent_id','id')
            ->where('IsEnable',true)->orderByDesc('Order');
    }

    public function Courses()
    {
        return $this->belongsToMany(Course::class,'course_categories',
            'category_id','course_id')
            ->where('IsEnable',true)->orderByDesc('Order');
    }

    public function CoursesPanel()
    {
        return $this->belongsToMany(Course::class,'course_categories',
            'category_id','course_id')->orderByDesc('Order');
    }

    /************static*************/
    public static function GetCategoryIsEnable($value=true)
    {//Get All Categorires => IsEnable = true
        return self::query()->where('IsEnable',$value)->orderByDesc('Order');
    }

    public static function GetSpecialCategory($limit = 5)
    {
        return self::GetCategoryIsEnable(true)->
        where('IsSpecial',true)->limit($limit)->get();
    }

    public static function Parents($category,$array,$where = null)
    {
        if($where == null){
            $category = self::Parent($category)->first();
            if($category == null){
                return $array;
            }else{
                $array[] = $category;
                return self::Parents($category,$array);
            }
        }
        $category = $category->Parent;
        if($category == null){
            return $array;
        }else{
            $array[] = $category;
            return self::Parents($category,$array);
        }

    }

    public static function Parent(CoursesCategory $category){
        return self::query()->where([
            'IsEnable' => true,
            'id' => $category->parent_id
        ]);
    }


    /************privet***********/
    /************End***********/





    public function GetCoursesByCategory()
    {
        return $this->belongsToMany(Course::class,'course_categories',
        'category_id','course_id')
            ->where('IsEnable',true)
            ->orderByDesc('Order');
    }

    public static function GetCategory($where=null)//GetCategoryBySlug
    {//Get Category By Column Get Categories Enable
        if(!$where){
            return CoursesCategory::query()->where('IsEnable',true);
        }
        return CoursesCategory::query()->where('IsEnable' , true)->where($where);
    }



    public static function GetCategoriesParent($limit = 10)
    {
        return  self::GetCategoryIsEnable(true)->where('parent_id',null)->limit($limit)->get();
    }
















    private static function GetIds($ids,$category)
    {
        if($category->Level != 2){
            $categories = $category->Children;
            foreach ($categories as $category) {
                $ids[] = $category->id;
                self::GetCategoryIsEnable(true)->GetIds($ids,$category);
            }

            return $ids;
        }else{

            return $ids;
        }

//        Setting::query()->whereIn("Key",[
//            "SiteSettings",
//            "SiteContacts"
//        ])->first();
//
//        [
//            "Part1" => [
//                "Text" => "dfgsgdfg",
//                "Image" => "sfgsfgsdfg"
//            ],
//        ]
    }

    public  static  function GetCourcessBySlugCategory($slug, $limit = 10,$where="1=1",$orderBy="created_at DESC"){

        $category = self::GetCategoryIsEnable(true)->GetCategoryBySlug($slug);
        $ids = [];
        $ids[] = $category->id;
        $arrayIds = self::GetIds($ids,$category);
        return Course::query()->whereRaw($where)->/*with("categories")->*/whereHas("categories",function($cat) use ($arrayIds){
            $cat->whereIn("course_categories.id",$arrayIds);
        })->orderByRaw($orderBy)->paginate($limit);
    }
}
