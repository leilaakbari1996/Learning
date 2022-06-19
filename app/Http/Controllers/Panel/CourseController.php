<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\PanelCourseRequest;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Course;
use App\Models\CoursesCategory;
use App\Models\Guidance;
use App\Models\Podcast;
use App\Models\Tag;
use App\Models\Video;
use App\Models\VideosTitle;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input;

class CourseController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست دوره ها');

        $courses = Course::GetAllCoursesByEnable()->get();

        return view('panel.course.index', compact('courses'));
    }

    public function show(Course $course)
    {
        \Head::SetTitle($course->Slug);

        return view('panel.course.show',compact('course'));
    }

    public function create()
    {
        \Head::SetTitle('ایجاد دوره ی جدید');

        return view('panel.course.create');
    }

    public function store(PanelCourseRequest $request)
    {

        if (!$request->hasFile('PreviewImageURl')) {
            return response()->json(['message' => 'Missing file'], 422);
        }
        $folderTime = folderTime();//2022_06
        $validateData = $request->validated();
        $video = [];

        //--------------- <editor-fold description="PreviewImageURl">--------------//
        $image = $validateData['PreviewImageURl'];
        $imageAddress = "./uploads/".$folderTime."/courses/images/previews/";
        $imagePre = save_image($imageAddress,$image)[0];
        $validateData = delete_add_validateData($validateData,'PreviewImageURl',$imagePre);
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Videos">--------------//
        if(!empty($validateData['Videos'])){
            $videos = $validateData['Videos'];
            $videoAddress = './uploads'.$folderTime.'/courses/videos/';
            $shom = 0;
            foreach ($videos as $item){
                $video[] = move_videos($videoAddress,$item,$shom);
                $shom++;
            }
        }
        $video = json_encode($video);
        $validateData = delete_add_validateData($validateData,'Videos',$video);
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Images">--------------//
        $image = [];
        if(!empty($validateData['Images'])){
            $images = $validateData['Images'];
            $imageAddress = './uploads/'.$folderTime.'/courses/images/';

            $shom = 0;
            foreach ($images as $item){
                $image[] = save_image($imageAddress,$item,$shom)[0];
                $shom++;
            }
        }
        $image = json_encode($image);
        $validateData = delete_add_validateData($validateData,'Images',$image);
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Delete and Add to ValidateData And Decode">--------------//



        $array = ['VideoTitles','Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances','Categories'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $videoTitles = $element['VideoTitles'];
        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];
        $categories = $element['Categories'];

        //---------------- </editor-fold> -------------------------//

        $course = Course::create($validateData);

        //--------------- <editor-fold description="Video Titles">--------------//
        if(!empty($videoTitles)){
            foreach ($videoTitles as $videoTitle) {
                $parent = VideosTitle::create([
                    'course_id' => $course->id,
                    'Title' => $videoTitle['Title'],
                    'parent_id' => null,

                ]);
                if (!empty($videoTitle['children'])) {
                    foreach ($videoTitle['children'] as $child) {
                        VideosTitle::create([
                            'course_id' => $course->id,
                            'Title' => $child,
                            'parent_id' => $parent->id,
                        ]);
                    }
                }
            }
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="tags">--------------//
        if(!empty($tags)){
            foreach ($tags as $tag) {
                $tag = json_decode($tag, true);
                 $result = Tag::firstOrCreate([
                    'Title' => $tag
                ]);
                 $tagIds [] = $result->id;
            }
            $course->Tags()->attach($tagIds);
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Relateds">--------------//
        attach_related($course,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances,$categories);
        //---------------- </editor-fold> -------------------------//


        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The course was successfully saved.'
        ];

        return $response;

    }

    public function edit(Course $course)
    {
        \Head::SetTitle($course->Slug);

        return view('panel.course.edit', compact('course'));
    }

    public function update(Course $course,PanelCourseRequest $request)
    {

        $folderTime = folderTime();//2022_06
        $validateData = $request->validated();
        $video = [];

        //--------------- <editor-fold description="PreviewImageURl">--------------//
        $imagePre = $course->PreviewImageURL;

        if ($request->hasFile('PreviewImageURl')) {
            check_exists_delete($course->PreviewImageURl);
            $image = $validateData['PreviewImageURl'];
            $imageAddress = "./uploads/".$folderTime."/courses/images/previews/";
            $imagePre = save_image($imageAddress,$image)[0];
            $validateData = delete_add_validateData($validateData,'PreviewImageURl',$imagePre);
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Videos">--------------//
        $video = json_decode($course->Videos,true);
        if(!empty($validateData['Videos'])){

            $videos = $validateData['Videos'];
            $videoAddress = './uploads/'.$folderTime.'/courses/videos/';
            $shom = 0;
            foreach ($videos as $item){
                $video[] = move_videos($videoAddress,$item,$shom);
                $shom++;
            }
        }
        $video = json_encode($video);
        $validateData = delete_add_validateData($validateData,'Videos',$video);

        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Images">--------------//
        $image = json_decode($course->Images,true);
        if(!empty($validateData['Images'])){
            $images = $validateData['Images'];
            $imageAddress = './uploads/'.$folderTime.'/courses/image/';
            $shom = 0;
            foreach ($images as $item){
                $image[] = save_image($imageAddress,$item,$shom)[0];
                $shom++;
            }
        }

        $image = json_encode($image);
        $validateData = delete_add_validateData($validateData,'Images',$image);

        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Delete and Add to ValidateData And Decode">--------------//

        $array = ['VideoTitles','Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances','Categories'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $videoTitles = $element['VideoTitles'];
        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];
        $categories = $element['Categories'];

        //---------------- </editor-fold> -------------------------//

        $course->update($validateData);

        //--------------- <editor-fold description="Video Titles">--------------//

        if(!empty($videoTitles)){
            foreach ($videoTitles as $videoTitle) {
                $parent = VideosTitle::firstOrCreate([
                    'course_id' => $course->id,
                    'Title' => $videoTitle['Title'],
                    'parent_id' => null,

                ]);
                if (!empty($videoTitle['children'])) {
                    foreach ($videoTitle['children'] as $child) {
                        VideosTitle::firstOrCreate([
                            'course_id' => $course->id,
                            'Title' => $child,
                            'parent_id' => $parent->id,
                        ]);
                    }
                }
            }
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="tags">--------------//
        if(!empty($tags)){
            foreach ($tags as $tag) {
                $tag = json_decode($tag, true);
                $result = Tag::firstOrCreate([
                    'Title' => $tag
                ]);
                $tagIds [] = $result->id;
            }
            $tagIds = array_unique($tagIds);
            $course->Tags()->sync($tagIds);
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Relateds">--------------//
        sync_related($course,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances,$categories);

        //---------------- </editor-fold> -------------------------//


        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The course was successfully update.'
        ];

        return $response;

    }

    public function destroy(Course $course,Request $request)
    {
        //--------------- <editor-fold description="Delete Image Preview">--------------//
        check_exists_delete($course->PreviewImageURL);
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Delete Videos">--------------//
        $videos = $course->Videos;
        $videos = json_decode($videos,true);
        if(!empty($videos)){
            foreach ($videos as $video){
                check_exists_delete($video);
            }
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Delete Image">--------------//
        $images = $course->Images;
        $images = json_decode($images,true);
        if(!empty($images)){
            foreach ($images as $image){
                check_exists_delete($image);
            }
        }
        //---------------- </editor-fold> -------------------------//

        //step 1:delete veideoTitles parent_id != null step2:delete videoTitles parent_id == null.
        $videoT= VideosTitle::GetVideoTitle($course)->get();
        foreach ($videoT as $title){
            $title->Videos()->delete();
            if($title->parent_id){
                $title->delete();
            }
        }

        $course->delete();

        $response = [
            'status' => 1,
            'text' => $course,
            "data" => 'The course was successfully Deleted.'
        ];

        return  $response;


    }

    public function categories(Course $course)
    {
        $categories = $course->Categories;

        return view('panel.course.categories',compact('categories','course'));
    }

    public function categoryDelete(Course $course,Request $request)
    {
        $validateData = $request->validate([
            'categoryId' => 'required|exists:courses_categories,id',
        ]);

        $category = CoursesCategory::GetCategory(['id'=>$validateData['categoryId']])->first();
        $course->Categories()->detach($category);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'دسته بندی برای دوره حذف شد'
        ];

        return  $response;
    }

    public function related(Course $course)
    {
        $relatedPodcasts = $course->RelatedPodcasts;
        $relatedCourses = $course->RelatedCourses;
        $relatedGuidance = $course->RelatedGuidances;
        $relatedBlog = $course->RelatedBlog;


        return view('panel.related.index',compact('course','relatedCourses','relatedPodcasts'
            ,'relatedBlog','relatedGuidance'));
    }

    public function deleteRelated(Course $course,Request $request)
    {
        $validateData = $request->validate([
            'Related' => 'required|in:blogs,podcasts,courses,guidances',
            'id' => 'required|exists:'.$request->get('Related').',id',
        ]);

        $data = delete_related($validateData,$course);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }

    public function images(Course $course)
    {
        $images = $course->Images;
        $images = json_decode($images,true);

        return view('panel.course.image',compact('images','course'));
    }

    public function imagesDelete(Course $course,Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required'
        ]);

        $path = $validateData['image'];
        $images = $course->Images;
        $images = check_delete_path($images,$path);
        $course->update([
            'Images' => $images
        ]);

        $response = [
            'status' => 1,
            'data' => 'Image Remove successful',
            'text' => ''
        ];

        return $response;


    }

    public function videos(Course $course)
    {
        $videos = $course->Videos;
        $videos = json_decode($videos,true);

        return view('panel.course.path',compact('videos','course'));
    }

    public function videosDelete(Course $course,Request $request)
    {
        $validateData = $request->validate([
            'video' => 'required'
        ]);

        $path = $validateData['video'];
        $videos = $course->Videos;
        $videos = check_delete_path($videos,$path);
        $course->update([
            'Videos' => $videos
        ]);

        $response = [
            'status' => 1,
            'data' => 'Image Remove successful',
            'text' => ''
        ];

        return $response;


    }

}
