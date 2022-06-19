<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public static function GetSettings(Request $request)
    {
        $settings = Setting::GetSettings();
        $settings = separate_settings($settings);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $settings
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
}
