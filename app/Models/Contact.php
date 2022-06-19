<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Email',
        'PhoneNumber',
        'Status',
        'Subject',
        'Text',
    ];

    public static function GetContact($where=null)
    {
        if(!$where){
            return self::all();
        }
        return self::query()->where($where);
    }
}
