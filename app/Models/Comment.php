<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'Text',
        'parent_id',
        'commentable_id',
        'commentable_type',
        'user_id',
        'Status',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function Children()
    {

        return Comment::query()->where([
            'parent_id' => $this->id,
            'Status' => 'Accepted'
        ])->paginate(10);
    }

    /*************static*/

    public static function GetComment($where = null)
    {
        if(!$where){
            return self::all();
        }
        return  self::query()->where($where);
    }
    /*end*/
}
