<?php

class Head
{
    private static $title;
    private static $description;

    public static function SetTitle($str)
    {
        self::$title = $str;
    }

    public static function SetDescription($str)
    {
        self::$description = $str;
    }

    public static function GetTitle()
    {
        return self::$title;
    }

    public static function GetDescription()
    {
        return self::$description;
    }
}
