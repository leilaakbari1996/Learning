<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست تنظیمات');
        $settings = Setting::all();
        $settings = settings($settings);

        return view('panel.setting.index',compact('settings'));
    }

    public function edit()
    {
        $settings = Setting::all();

        return view('panel.setting.edit',$settings);
    }

    /*public function store(Request $request)
    {
        $validateData = $request->validate([
            'settings' => 'required',
        ]);
        $settings = $validateData['settings'];
        $settings = json_decode($settings,true);
        $keys = Setting::all();
        $items = $keys->toArray();
        $results = [];
        foreach ($items as $item){
            $results[] = $item['Key'];
        }
        foreach ($settings as $setting) {
            $key = array_keys($setting);
            $key = $key[0];
            $value = array_values($setting)[0];
            if(in_array($key,$results)){
                $record = Setting::query()->where('Key',$key)->first();
                $record->update([
                    'Value' => $value
                ]);

            }else {
                Setting::create([
                    'Key' => $key,
                    'Value' => $value
                ]);
            }
        }

        $response = [
            'status' => 1,
            'data' => 'settings succssefull saved',
            'text' => ''
        ];

        return $response;

    }*/

    public function update(Request $request)
    {
        $validateData = $request->validate([
            'settings' => 'required',
        ]);
        $settings = $validateData['settings'];
        $settings = json_decode($settings,true);
        $keys = Setting::all();
        $items = $keys->toArray();
        $results = [];
        foreach ($items as $item){
            $results[] = $item['Key'];
        }
        foreach ($settings as $setting) {
            $key = array_keys($setting);
            $key = $key[0];
            $value = array_values($setting)[0];
            if(in_array($key,$results)){
                $record = Setting::query()->where('Key',$key)->first();
                $record->update([
                    'Value' => $value
                ]);

            }else {
                $response = [
                    'status' => 0,
                    'data' => '',
                    'text' => 'نمیتواند ویرایش شود چون '.$key.'جز کیلد ها نمی باشد.'
                ];

                return $response;
            }
        }

        $response = [
            'status' => 0,
            'data' => 'setting updated',
            'text' => 'updated'
        ];

        return $response;


    }

    public function destroy(Request $request)
    {
        $validateData = $request->validate([
            'key' => 'required|exists:settings,key'
        ]);
        $setting = Setting::query()->where('key',$validateData['key'])->first();
        $setting->delete();

        $respone = [
            'status' => 1,
            'data' => 'setting successfull remove.',
            'text' => ''
        ];
        return $respone;
    }

    public function destroySetting(Request $request)
    {
        $validateData = $request->validate([
            'keyMain' => 'required|exists:settings,key',
            'key' => 'required|string'
        ]);
        $setting = Setting::query()->where('key',$validateData['keyMain'])->first();
        $values = $setting->Value;
        $keys = array_keys($values);
        if(in_array($validateData['key'],$keys)){
            unset($values[$validateData['key']]);
            $setting->update([
                'Value' => $values
            ]);
            $data = 'setting successfull remove.';
        }else{
            $data = 'setting موجود نیست';
        }
        $respone = [
            'status' => 1,
            'data' => $data,
            'text' => ''
        ];
        return $respone;
    }
}
