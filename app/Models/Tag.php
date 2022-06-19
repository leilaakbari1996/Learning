<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'Title',
        'Slug',
    ];

    public function sluggable(): array
    {
        return [
            "Slug" => [
                "source" => "Title"
            ]
        ];
    }

    public function Courses()
    {
        return  $this->morphedByMany(Course::class,'tagable',"tag_all");
    }

    public static  function GetTags($where=null)
    {
        if(!$where){
            return self::all();
        }
        return self::query()->where($where);
    }
    /*end*/
}
