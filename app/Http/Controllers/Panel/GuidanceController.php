<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuidanceRequest;
use App\Http\Requests\PodcastPanelRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Course;
use App\Models\Guidance;
use App\Models\Podcast;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index()
    {
        $guidances = Guidance::GetGuidence()->limit(20)->get();

        return view('panel.guidance.index',compact('guidances'));
    }

    public function show(Guidance $guidance)
    {
        \Head::SetTitle($guidance->Title);

        return view('panel.guidance.show',compact('guidance'));
    }

    public function edit(Guidance $guidance)
    {
        \Head::SetTitle($guidance->Title);

        return view('panel.guidance.edit',compact('guidance'));
    }

    public function create()
    {
        \Head::SetTitle('podcast');
        return view('panel.guidance.create');
    }

    public function store(GuidanceRequest $request)
    {

        $validateData = $request->validated();
        $folderTime = folderTime();

        //--------------- <editor-fold description="Image Video Icon">--------------//
        if($request->hasFile('ImageURL')){
            $image = $validateData['ImageURL'];
            $imageAddress = "./uploads/".$folderTime."/guidances/images/";
            $image = save_image($imageAddress,$image)[0];
            $validateData = delete_add_validateData($validateData,'ImageURL',$image);
        }

        if($request->hasFile('IconURL')){
            $icon = $validateData['IconURL'];
            $IconAddress = './uploads/'.$folderTime.'guidances/icons/';
            $icon = save_image($IconAddress,$icon)[0];
            $validateData = delete_add_validateData($validateData,'IconURL',$icon);
        }

        if($request->hasFile('VideoURL')){
            $video = $validateData['VideoURL'];
            $videoAddress = './uploads/'.$folderTime.'guidances/videos/';
            $video = move_videos($videoAddress,$video);
            $validateData = delete_add_validateData($validateData,'VideoURL',$video);
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Delete and Add to ValidateData And Decode">--------------//

        $array = ['Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances','Courses'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];
        $courses = $element['Courses'];

        //---------------- </editor-fold> -------------------------//

        $guidance = Guidance::create($validateData);

        //--------------- <editor-fold description="Related">--------------//

        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Related">--------------//
        attach_related($guidance,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances);

        if(!empty($courses)){
            $courses = array_unique($courses);
            $guidance->Courses()->attach($courses);
        }
        //---------------- </editor-fold> -------------------------//

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The guidance was successfully saved.'
        ];

        return  $response;

    }

    public function update(Guidance $guidance,GuidanceRequest $request)
    {
        $validateData = $request->validated();
        $image = $guidance->ImageURL;
        $video = $guidance->VideoURL;
        $icon = $guidance->IconURL;
        $folderTime = folderTime();

        //--------------- <editor-fold description="Image Video Icon">--------------//
        if($request->hasFile('ImageURL')){
            $image = $validateData['ImageURL'];
            $imageAddress = "./uploads/".$folderTime."/guidances/images/";
            $image = save_image($imageAddress,$image)[0];
        }
        $validateData = delete_add_validateData($validateData,'ImageURL',$image);

        if($request->hasFile('IconURL')){
            $icon = $validateData['IconURL'];
            $IconAddress = './uploads/'.$folderTime.'guidances/icons/';
            $icon = save_image($IconAddress,$icon)[0];
        }
        $validateData = delete_add_validateData($validateData,'IconURL',$icon);

        if($request->hasFile('VideoURL')){
            $video = $validateData['VideoURL'];
            $videoAddress = './uploads/'.$folderTime.'guidances/videos/';
            $video = move_videos($videoAddress,$video);
        }
        $validateData = delete_add_validateData($validateData,'VideoURL',$video);

        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Delete and Add to ValidateData And Decode">--------------//

        $array = ['Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances','Courses'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];
        $courses = $element['Courses'];

        //---------------- </editor-fold> -------------------------//


        $guidance->update($validateData);
        //--------------- <editor-fold description="Related">--------------//
        sync_related($guidance,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances);

        if(!empty($courses)){
            $courses = array_unique($courses);
            $guidance->Courses()->sync($courses);
        }
        //---------------- </editor-fold> -------------------------//


        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The guidance was successfully updated.'
        ];

        return  $response;
    }

    public function destroy(Guidance $guidance)
    {
        check_exists_delete($guidance->VideoURL);
        check_exists_delete($guidance->ImageURL);
        check_exists_delete($guidance->IconURL);

        $guidance->delete();

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'حذف مسیر راهنما'
        ];

        return  $response;
    }

    public function courses(Guidance $guidance)
    {
        $courses = $guidance->Courses;

        return view('panel.guidance.courses',compact('guidance','courses'));
    }

    public function coursesDelete(Guidance $guidance,Request $request)
    {
      $validateData = $request->validate([
            'courseId' => 'required|exists:courses,id',
        ]);


        $course = Course::GetAllCoursesByEnable(true,['id'=>$validateData['courseId']])->first();
        $guidance->Courses()->detach($course);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'این دوره از مسیر راهنما حذف شد'
        ];

        return  $response;
    }

    public function related(Guidance $guidance)
    {
        $relatedPodcasts = $guidance->RelatedPodcasts;
        $relatedCourses = $guidance->RelatedCourses;
        $relatedGuidance = $guidance->RelatedGuidances;
        $relatedBlog = $guidance->RelatedBlog;


        return view('panel.guidance.related',compact('guidance','relatedCourses','relatedPodcasts'
            ,'relatedBlog','relatedGuidance'));
    }

    public function deleteRelated(Guidance $guidance,Request $request)
    {
        $validateData = $request->validate([
            'Related' => 'required|in:blogs,podcasts,courses,guidances',
            'id' => 'required|exists:'.$request->get('Related').',id',
        ]);

        $data = delete_related($validateData,$guidance);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }


}
