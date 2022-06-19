<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public const SiteTitle = "SiteTitle";
    public const SiteDescription = 'Description';
    public const SocialMediaLinks = "{
                'Instagram' : '#',
                'facebook' : '#'
    }";
    public const SectionsSite = "{
                'SpecialCourse' : '#',
                'contact' : '#',
    }";
    public const WaysOfCommunication = "{
                'SupportPhone': '1536',
                'Address':'shz',
                'Email': 'info@.com'
    }";
    public const Logo ="{
        'ffffff',
    }";

    protected $fillable = [
        'Key',
        'Value',
    ];

    protected $casts = [
        "Value" => "array"
    ];

    public static function GetSettings()
    {
        return  self::all();
    }

    public static function Get($key, $isJson = false)
    {
        return self::firstOrCreate(
            ["key" => $key],
            ["value" => ""]
        );
    }

    public static function Set($key, $value, $isJson = false)
    {

    }
}
