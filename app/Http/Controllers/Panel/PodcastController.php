<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPanelRequest;
use App\Http\Requests\PodcastPanelRequest;
use App\Models\Blog;
use App\Models\Course;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PodcastController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست پادکست ها');
        $podcasts = Podcast::GetPodcast()->get();

        return view('panel.podcast.index',compact('podcasts'));
    }

    public function show(Podcast $podcast)
    {
        \Head::SetTitle($podcast->Title);

        return view('panel.podcast.show',compact('podcast'));
    }

    public function edit(Podcast $podcast)
    {
        \Head::SetTitle($podcast->Title);

        return view('panel.podcast.edit',compact('podcast'));
    }

    public function create()
    {
        \Head::SetTitle('ایجاد پادکست جدید');

        return view('panel.podcast.create');
    }

    public function store(PodcastPanelRequest $request)
    {
        if (!$request->hasFile('ImageURL') || !$request->hasFile('AudioURL')) {
            return response()->json(['message' => 'Missing file'], 422);
        }

        $validateData = $request->validated();
        $folderTime = folderTime();
        //--------------- <editor-fold description="Image Audio thumbnail">--------------//
        $image = $validateData['ImageURL'];
        $imageAddress = "./uploads/".$folderTime."/podcasts/images/";
        $image = save_image($imageAddress,$image);
        $validateData = delete_add_validateData($validateData,'ImageURL',$image[0]);

        $audio = $validateData['AudioURL'];
        $audioAddress = './uploads/'.$folderTime.'podcasts/audios/';
        $audioURL = move_videos($audioAddress,$audio,0,'.mp3');
        $validateData = delete_add_validateData($validateData,'AudioURl',$audioURL);


        $ThumbnailURL = thumbnail($image[1]);
        $thumbnailAddress = "./uploads/".$folderTime."podcasts/thumbnail/";
        $ThumbnailURL = save_thumbnail($thumbnailAddress,$ThumbnailURL);
        $validateData = delete_add_validateData($validateData,'ThumbnailURl',$ThumbnailURL);

        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Related">--------------//
        $array = ['Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];

        //---------------- </editor-fold> -------------------------//


        $podcast = Podcast::create($validateData);

        //--------------- <editor-fold description="Related">--------------//
        attach_related($podcast,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances);
        //---------------- </editor-fold> -------------------------//

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The podcast was successfully saved.'
        ];

        return  $response;

    }

    public function update(Podcast $podcast,PodcastPanelRequest $request)
    {

        $validateData = $request->validated();

        //--------------- <editor-fold description="Image audio Thumbnail">--------------//
        $image = $podcast->ImageURL;
        $ThumbnailURl = $podcast->ThumbnailURl;
        $folderTime = folderTime();

        if($request->hasFile('ImageURL')) {
            check_exists_delete($image);
            check_exists_delete($ThumbnailURl);

            $image = $validateData['ImageURL'];
            $imageAddress = "./uploads/" . $folderTime . "/podcasts/images/";
            $image = save_image($imageAddress, $image);
            $validateData = delete_add_validateData($validateData, 'ImageURL', $image[0]);

            $ThumbnailURL = thumbnail($image[1]);
            $thumbnailAddress = "./uploads/".$folderTime."podcasts/thumbnail/";
            $ThumbnailURl = save_image($thumbnailAddress,$ThumbnailURL)[0];
        }
        $validateData = delete_add_validateData($validateData,'ThumbnailURl',$ThumbnailURl);

        $audio = $podcast->AudioURl;
        if($request->hasFile('AudioURL')) {
            $audio = $validateData['AudioURL'];
            $audioAddress = './uploads/'.$folderTime.'podcasts/audios/';
            $audio = move_videos($audioAddress,$audio,0,'.mp3');
        }

        $validateData = delete_add_validateData($validateData,'AudioURL',$audio);

        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Related">--------------//
        $array = ['Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];

        //---------------- </editor-fold> -------------------------//


        $podcast->update($validateData);

        //--------------- <editor-fold description="Related">--------------//
        sync_related($podcast,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances);
        //---------------- </editor-fold> -------------------------//



        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The podcast was successfully updated.'
        ];

        return  $response;

    }

    public function destroy(Podcast $podcast)
    {

        check_exists_delete($podcast->ImageURL);
        check_exists_delete($podcast->AudioURl);
        $podcast->delete();

        $response = [
            'status' => 1,
            'text' => $podcast,
            "data" => 'The podcast was successfully Deleted.'
        ];

        return  $response;
    }

    public function related(Podcast $podcast)
    {
        $relatedPodcasts = $podcast->RelatedPodcasts;
        $relatedCourses = $podcast->RelatedCourses;
        $relatedGuidance = $podcast->RelatedGuidances;
        $relatedBlog = $podcast->RelatedBlog;


        return view('panel.podcast.related',compact('podcast','relatedCourses','relatedPodcasts'
            ,'relatedBlog','relatedGuidance'));
    }

    public function deleteRelated(Podcast $podcast,Request $request)
    {
        $validateData = $request->validate([
            'Related' => 'required|in:blogs,podcasts,courses,guidances',
            'id' => 'required|exists:'.$request->get('Related').',id',
        ]);

        $data = delete_related($validateData,$podcast);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }


}
