<?php

use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


function check_exists_file_create($path)
{
    if(!File::exists($path)){
        File::makeDirectory($path,0755, true);
    }
}

function get_info_decode_delete_validateData($elements,$validateData)
{
    $result = [];

    foreach ($elements as $element){
        if(!empty($validateData[$element])) {
            if(!is_array($validateData[$element])){
                $result[$element] = json_decode($validateData[$element], true);
            }else{
                $result[$element] = $validateData[$element];
            }
        }else{
            $result[$element] = null;
        }
        unset($validateData[$element]);
    }

    return [$result,$validateData];
}

function delete_array($elements,$array)
{
    foreach ($elements as $element){
        unset($array[$element]);
    }

    return $array;
}

function delete_add_validateData($validateData,$element,$item)
{
       unset($validateData[$element]);
       $validateData[$element] = $item;
       return $validateData;
}

function save_image($imageAddress,$image,$shom=0)
{
    check_exists_file_create($imageAddress);
    $imageName = time() .$shom.".webp";
    $image = resize($image);
    $image->save($imageAddress . '/' . $imageName);
    return [$imageAddress . $imageName,$image];

}

function save_thumbnail($imageAddress,$image,$shom=0)
{
    check_exists_file_create($imageAddress);
    $imageName = time() .$shom.".webp";
    $image->save($imageAddress . '/' . $imageName);
    return $imageAddress . $imageName;

}

function move_videos($videoAddress,$item,$shom=0,$format=".mp4")
{
    $videoName = time() .$shom. $format;
    $item->move($videoAddress, $videoName);
    return $videoAddress . $videoName;
}

function attach_related($item,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances,$categories=null)
{
    if(!empty($relatedCourses)){
        $relatedCourses = array_unique($relatedCourses);
        $item->RelatedCourses()->attach($relatedCourses);
    }

    if(!empty($relatedPodcasts)){
        $relatedCourses = array_unique($relatedCourses);
        $item->RelatedPodcasts()->sync($relatedCourses);
    }

    if(!empty($relatedBlogs)){
        $relatedBlogs = array_unique($relatedBlogs);
        $item->RelatedBlog()->attach($relatedBlogs);
    }

    if(!empty($relatedGuidances)){
        $relatedGuidances = array_unique($relatedGuidances);
        $item->RelatedGuidances()->attach($relatedGuidances);
    }

    if(!empty($categories)){
        $categories = array_unique($categories);
        $item->Categories()->attach($categories);
    }
}

function sync_related($item,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances,$categories=null)
{
    if(!empty($relatedCourses)){
        $relatedCourses = array_unique($relatedCourses);
        $item->RelatedCourses()->sync($relatedCourses);
    }

    if(!empty($relatedPodcasts)){
        $relatedCourses = array_unique($relatedCourses);
        $item->RelatedPodcasts()->sync($relatedCourses);
    }

    if(!empty($relatedBlogs)){
        $relatedBlogs = array_unique($relatedBlogs);
        $item->RelatedBlog()->sync($relatedBlogs);
    }

    if(!empty($relatedGuidances)){
        $relatedGuidances = array_unique($relatedGuidances);
        $item->RelatedGuidances()->sync($relatedGuidances);
    }

    if(!empty($categories)){
        $categories = array_unique($categories);
        $item->Categories()->sync($categories);
    }
}

function delete_related($validateData,$item)
{
    if($validateData['Related'] == 'podcasts') {
        $item->RelatedPodcasts()->detach($validateData['id']);
        $data = 'remove of list related podcasts ';
    }else if($validateData['Related'] == 'blogs'){
        $item->RelatedBlog()->detach($validateData['id']);
        $data = 'remove of list related blogs';
    }else if($validateData['Related'] == 'courses'){
        $item->RelatedCourses()->detach($validateData['id']);
        $data = 'remove of list related courses';
    }else if($validateData['Related'] == 'guidances'){
        $item->RelatedGuidances()->detach($validateData['id']);
        $data = 'remove of list related guidances';
    }else{
        $data = 'نامعتبر';
    }

    return $data;
}
function separate_parent_child($array)//ordering Categories-videoTitles According to Childs
{
    $item = [];

    foreach ($array as $title){
        if($title->parent_id == null){

            $child = [];
            foreach ($array as $video){
                if($video->parent_id == $title->id){
                    $child [] = $video;
                }
            }
            $item [] = [
                'parent' => $title,
                'child' => $child
            ];
        }
    }
    return $item;
}


function separate_settings($settings)
{
    $keys = $settings->pluck('Key')->all();
    $keys = array_unique($keys);
    $array = [];
    foreach ($keys as $key){
        $item["key"] = $key;
        $item['values'] = [];
        foreach ($settings as $setting){
            if($setting->Key == $key){
                $item['values'][] = $setting['Value'];

            }
        }
        $array [] = $item;
    }
    return $array;
}

function separate_comments($comments,$parents)
{
    $courses = [];
    $podcasts = [];
    $blogs = [];
    foreach ($comments as $comment) {
        if ($comment->commentable_type == 'App\Models\Podcast') {
            $podcasts = comment($parents,$comment);
        } else if ($comment->commentable_type == 'App\Models\Blog') {
            $blogs = comment($parents,$comment);
        }else if ($comment->commentable_type == 'App\Models\Course') {
            $courses[] = comment($parents,$comment);
        }
    }

    return [$courses, $podcasts, $blogs];
}

function comment($parents,$comment)
{
    $result = [
        'UnRead' => $comment
    ];
    if ($comment->parent_id) {
        foreach ($parents as $parent) {
            if ($parent->id == $comment->parent_id) {
                $result['parent'] = $parent;
            }
        }
    }

    return $result;
}

function folderTime()
{
    return Carbon::parse(now())->format("Y_m");
}

function check_exists_delete($url)
{
    if($url != null) {
        $path = public_path() . $url;
        if(File::exists($url)){
            File::delete($path);
        }
    }
}

function check_delete_path($array,$path)
{
    $array = json_decode($array,true);
    if(in_array($path,$array)){
        check_exists_delete($path);
        $key = array_search($path, $array, true);
        unset($array[$key]);
    }

    $array = json_encode($array);

    return $array;
}

function settings($settings)
{
    $settings = json_decode($settings,true);
    $results = [];
    foreach ($settings as $setting) {
        $keyMain = $setting['Key'];
        $values = $setting['Value'];
        if(is_array($values)){
            $keys = array_keys($values);
            $result = [];
            foreach ($keys as $key){
                $item =[
                    'key' => $key,
                    'value' => $values[$key]
                ];
                $result [] = $item;
            }
            $values = $result;
        }
        $results [] = [
            'key' => $keyMain,
            'value' => $values
        ];
    }
    return $results;
}
/***********End*********/
function resize($image)
{
    $image = Image::make($image->getRealPath());

    $canvas = Image::canvas(450,450,"#fff")->encode("webp");

    $width = 450;
    $height = 450;

    $image->height() > $image->width()? $width = null:$height = null;

    $image->resize($width, $height,function ($c){
        $c->aspectRatio();
    });

    $canvas->insert($image,'center');

//    $watermark = Image::make("./assets/");
//
//    $canvas->insert($watermark,"bottom-left",20,20);

    return $canvas;
}


function thumbnail(\Intervention\Image\Image $image)
{
    return $image->resize(225,225, function($c){
        $c->aspectRatio();
    });
}



function show_separate_parent_child($arrays,$url)
{
    $item = [];
    foreach ($arrays as $array){
        $parent = $array['parent'];
        $route = 'client.'.$url.'.show';
        echo '<h3><a href="'.route($route,$parent->Slug).'">'.$parent->id.'</a></h3>';
        if(count($array['child']) != 0)
        {
            foreach ($array['child'] as $child){
                echo '<a href="'.route($route,$child->Slug).'">child:'.$child->id.'</a>';
            }
        }
    }
}

function show_array($title,$array,$url)
{


        echo '<h1>' . $title . '</h1>';
        foreach ($array as $item) {
            if(!empty($item)){
                $slug = $item->Slug;
                $route = 'client.'.$url.'.show';
                echo'<h5><a href="' . route($route,$slug) .'">' . $item->id . ' </a></h5>';

            }
        }


}

function show_array_master($title,$array,$url)
{


    echo '<h1>' . $title . '</h1>';
    foreach ($array as $item) {
        if(!empty($item)){
            $route = 'client.'.$url.'.show';
            echo'<h5><a href="' . route($route,$item) .'">' . $item->id . ' </a></h5>';

        }
    }


}

function show_array_tag($title,$array,$url)
{
    echo '<h1>' . $title . '</h1>';
    foreach ($array as $item) {
        if(!empty($item)){

            echo'<h5>'.$item->Slug.'</h5>';

        }
    }
}

function show_array_banner($title,$array,$url)
{
    echo '<h1>' . $title . '</h1>';
    foreach ($array as $item) {
        if(!empty($item)){
            $route = 'client.'.$url.'.show';
            echo'<h5><a href="'.route($route,$item).'"> '.$item->Title.'</a></h5>';

        }
    }
}

function show_array_panel($title,$array,$url)
{


    echo '<h1>' . $title . '</h1>';
    foreach ($array as $item) {
        if(!empty($item)){
            $slug = $item->Slug;
            $route = 'panel.'.$url.'.index';
            echo '<h5><a href="' . route($route) .'">' . $item->id . ' </a></h5>';


        }
    }


}

function arrange($title,$array){
    echo '<h2>'.$title.'</h2>';
    foreach($array as $child){
        echo $child->id.'  ';
    }
}

function computing($items,$column)
{
    $sum = 0;
    foreach ($items as $item){

        $sum += ($item->$column * $item->pivot->Count);
    }
    return $sum;
}

function showByColumn($title,$specialCategories,$courses)
{
    echo '<h1>'.$title.'</h1>';
    echo '<ul>';
        echo '<li>All courses</li>';
        foreach($specialCategories as $category) {
            echo '<li><a href="/category/'.$category->Slug.'">', $category->id . '</a></li>';
        }
        echo '</ul>';
            foreach($courses as $course){
                echo '<h5><a href="/course/'.$course->Slug.'">'.$course->id.'</a></h5>';
            }
            echo '<hr>';
}

