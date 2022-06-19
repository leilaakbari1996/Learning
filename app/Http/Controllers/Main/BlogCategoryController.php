<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Api\BlogController as BlogApi;
use \App\Http\Controllers\Api\BlogCategoryController as BlogCategoryApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('BlogCategories');
        $blogCategories = BlogCategoryApi::GetBlogCategories($request,10)['data'];

        return view('client.categoryBlog.index',compact('blogCategories'));
    }

    public function show(Request $request,$slug)
    {
        \Head::SetTitle('BlogCategory');
        $blogCategory = BlogCategoryApi::GetBlogCategories($request,1,['Slug' => $slug])['data'];
        $blogCategory = $blogCategory[0];
        if(empty($blogCategory)){
            abort(404);
        }

        $blogs = BlogCategoryApi::Blogs($request,$blogCategory,10)['data'];


        return  view('client.categoryBlog.show',compact('blogCategory','blogs'));
    }
}
