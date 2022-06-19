<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPanelRequest;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Course;
use App\Models\CoursesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست بلاگ ها');
        $blogs = Blog::GetBlogs(20)->get();

        return view('panel.blog.index',compact('blogs'));
    }

    public function show(Blog $blog)
    {
        \Head::SetTitle($blog->Slug);

        return view('panel.blog.show',compact('blog'));
    }

    public function create()
    {
        \Head::SetTitle('ایجاد بلاگ');

         return view('panel.blog.create');
    }

    public function store(BlogPanelRequest $request)
    {
        if (!$request->has('ImageURL')) {
            return response()->json(['message' => 'Missing file'], 422);
        }
        $folderTime = folderTime();
        $validateData = $request->validated();
        //--------------- <editor-fold description="Image">--------------//
        $image = $validateData['ImageURL'];
        $imageAddress = "./uploads/".$folderTime."/blogs/images/";
        $image = save_image($imageAddress,$image);
        $validateData = delete_add_validateData($validateData,'ImageURl',$image[0]);
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="ThumbnailURL">--------------//
        $ThumbnailURL = thumbnail($image[1]);
        $thumbnailAddress = "./uploads/".$folderTime."/blogs/thumbnails/";
        $Thumbnail = save_thumbnail($thumbnailAddress,$ThumbnailURL);
        $validateData = delete_add_validateData($validateData,'ThumbnailURl',$Thumbnail);
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Related">--------------//
        $array = ['Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances','Categories'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];
        $categories = $element['Categories'];

        //---------------- </editor-fold> -------------------------//

        $blog = Blog::create($validateData);

        //--------------- <editor-fold description="Related">--------------//
        attach_related($blog,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances,$categories);
        //---------------- </editor-fold> -------------------------//

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The blog was successfully saved.'
        ];

        return  $response;



    }

    public function edit(Blog $blog)
    {
        \Head::SetTitle($blog->Slug);

        return view('panel.blog.edit',compact('blog'));
    }

    public function update(Blog $blog,BlogPanelRequest $request)
    {
        $validateData = $request->validated();
        //--------------- <editor-fold description="Image and Thumbnail">--------------//
        $image = $blog->ImageURL;
        $folderTime = folderTime();
        $ThumbnailURL = $blog->ThumbnailURL;
        if($request->hasFile('ImageURL')) {
            check_exists_delete($image);
            check_exists_delete($ThumbnailURL);

            $image = $validateData['ImageURL'];
            $imageAddress = "./uploads/".$folderTime."blogs/images/";
            $image = save_image($imageAddress,$image);
            $validateData = delete_add_validateData($validateData,'ImageURL',$image);

            $ThumbnailURL = thumbnail($image);
            $thumbnailAddress = "./uploads/".$folderTime."/blogs/thumbnails/";
            $ThumbnailURL = save_image($thumbnailAddress,$ThumbnailURL);
            $validateData = delete_add_validateData($validateData,'ThumbnailURl',$ThumbnailURL);
        }
        //---------------- </editor-fold> -------------------------//

        //--------------- <editor-fold description="Related">--------------//
        $array = ['Tags','RelatedCourses','RelatedPodcasts','RelatedBlogs','RelatedGuidances','Categories'];
        $result = get_info_decode_delete_validateData($array,$validateData);
        $validateData = $result[1];
        $element = $result[0];

        $tags = $element['Tags'];
        $relatedCourses = $element['RelatedCourses'];
        $relatedPodcasts = $element['RelatedPodcasts'];
        $relatedBlogs = $element['RelatedBlogs'];
        $relatedGuidances = $element['RelatedGuidances'];
        $categories = $element['Categories'];

        //---------------- </editor-fold> -------------------------//

        $blog->update($validateData);

        //--------------- <editor-fold description="Related">--------------//
        sync_related($blog,$relatedCourses,$relatedPodcasts,$relatedBlogs,$relatedGuidances,$categories);
        //---------------- </editor-fold> -------------------------//


        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The blog was successfully update.'
        ];

        return  $response;

    }

    public function destroy(Blog $blog,Request $request)
    {
        check_exists_delete($blog->ImageURL);
        $blog->delete();

        $response = [
            'status' => 1,
            'text' => $blog,
            "data" => 'The banner was successfully Deleted.'
        ];

        return  $response;
    }

    public function categories(Blog $blog)
    {
        $categories = $blog->Categories;

        return view('panel.blog.categories',compact('blog','categories'));
    }

    public function categoryDelete(Blog $blog,Request $request)
    {
        $validateData = $request->validate([
            'categoryId' => 'required|exists:blogs_categories,id',
        ]);

        $category = BlogCategory::GetCategories(1,['id'=>$validateData['categoryId']])->first();
        $blog->Categories()->detach($category);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'این دسته بندی برای بلاگ حذف شد'
        ];

        return  $response;
    }

    public function related(Blog $blog,Course $course)
    {
        $relatedPodcasts = $blog->RelatedPodcasts;
        $relatedCourses = $blog->RelatedCourses;
        $relatedGuidance = $blog->RelatedGuidances;
        $relatedBlog = $blog->RelatedBlog;


        return view('panel.blog.related',compact('blog','relatedCourses','relatedPodcasts'
            ,'relatedBlog','relatedGuidance'));
    }

    public function deleteRelated(Blog $blog,Request $request)
    {
        $validateData = $request->validate([
            'Related' => 'required|in:blogs,podcasts,courses,guidances',
            'id' => 'required|exists:'.$request->get('Related').',id',
        ]);

        $data = delete_related($validateData,$blog);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }




}
