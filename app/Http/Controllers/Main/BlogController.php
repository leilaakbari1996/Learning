<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Api\BlogController as BlogApi;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('Blogs');
        $blogs = BlogApi::GetBlog($request,10)['data'];

        return view('client.blog.index',compact('blogs'));
    }

    public function show(Request $request,$slug)
    {
        \Head::SetTitle('Blog');
        $blog = BlogApi::GetBlog($request,1,['Slug' => $slug])['data'];
        $blog = $blog[0];
        if(empty($blog)){
            abort(404);
        }
        $blogsRelated = BlogApi::RelatedBlog($request,$blog, 5)['data'];
        $coursesRelated = BlogApi::RelatedCourse($request,$blog,5)['data'];
        $podcastsRelated = BlogApi::RelatedPodcast($request,$blog,5)['data'];
        $guidancesRelated = BlogApi::RelatedGuidance($request,$blog,5)['data'];
        $tags = BlogApi::GetTag($request,$blog,4)['data'];
        $comments = BlogApi::GetComments($request,$blog)['data'];

        return  view('client.blog.show',compact('blog','blogsRelated','coursesRelated','tags','comments','podcastsRelated',
        'guidancesRelated'));
    }
}
