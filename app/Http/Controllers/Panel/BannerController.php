<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست بنر ها');

        $banners = Banner::BannerEnable(20);

        return view('panel.banner.index',compact('banners'));
    }

    public function show(Banner $banner)
    {
        \Head::SetTitle($banner->Title);

        return view('panel.banner.show',compact('banner'));
    }

    public function create()
    {
        \Head::GetTitle('Create Banner');

        return view('panel.banner.create');
    }

    public function store(BannerRequest $request)
    {
        if (!$request->has('ImageURL')) {
            return response()->json(['message' => 'Missing file'], 422);
        }
        $folderTime = folderTime();
        $validateData = $request->validated();
        //--------------- <editor-fold description="ImageURL">--------------//
        $image = $validateData['ImageURL'];
        $imageAddress = "./uploads/".$folderTime."/banners/images";
        $image = save_image($imageAddress,$image)[0];
        $validateData = delete_add_validateData($validateData,'ImageURL',$image);
        //---------------- </editor-fold> -------------------------//
        $banner = Banner::create($validateData);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The banner was successfully saved.'
        ];

        return  $response;
    }

    public function edit(Banner $banner)
    {
        \Head::SetTitle($banner->Title);

        return view('panel.banner.edit',compact('banner'));
    }

    public function update(Banner $banner,BannerRequest $request)
    {
        $validateData = $request->validated();
        $folderTime = folderTime();
        $image = $banner->ImageURL;
        if ($request->hasFile('ImageURL')) {
            check_exists_delete($banner->ImageURL);
            $image = $validateData['ImageURL'];
            $imageAddress = "./uploads/".$folderTime."/banners/images/";
            $image = save_image($imageAddress,$image);
        }
        $validateData = delete_add_validateData($validateData,'ImageURL',$image);

        $banner->update($validateData);

        $response = [
            'status' => 1,
            'text' => $banner,
            "data" => 'The banner was successfully updated.'
        ];

        return  $response;
    }

    public function destroy(Banner $banner,Request $request)
    {
        check_exists_delete($banner->ImageURL);
        $banner->delete();

        $response = [
            'status' => 1,
            'text' => $banner,
            "data" => 'The banner was successfully Deleted.'
        ];

        return  $response;


    }
}
