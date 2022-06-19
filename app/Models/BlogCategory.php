<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table ="blogs_categories";

    protected $fillable = [
        'Title',
        'Slug',
        'IsSpecial',
        'IsEnable',
        'parent_id'
    ];

    public function sluggable(): array
    {
        return [
            "Slug" => [
                "source" => "Title"
            ]
        ];
    }

    public function Blogs($limit=10)
    {
        return $this->belongsToMany(Blog::class,'blog_category',
            'category_id','blog_id')
            ->where('IsEnable',true)->orderByDesc('Order')->limit($limit);
    }

    public function BlogsPanel($limit=10)
    {
        return $this->belongsToMany(Blog::class,'blog_category',
            'category_id','blog_id')
            ->orderByDesc('Order')->limit($limit);
    }

    public static function GetCategories($limit = 5,$where=null)
    {
        if(!$where){
            return  self::query()->where('IsEnable' , true)->
            orderByDesc('Order')->limit($limit);
        }
        return  self::query()->where('IsEnable' , true)->
        orderByDesc('Order')->where($where)->limit($limit);

    }

    public static function GetspecialCategory($limit = 5)
    {

        return  self::query()->where([
            ['IsEnable' , true],
            ['IsSpecial' , true]
        ])->orderByDesc('Order')->paginate($limit);
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

    public static function Parent(BlogCategory $category){
        return self::query()->where([
            'IsEnable' => true,
            'id' => $category->parent_id
        ]);
    }
    /**end**/
}
