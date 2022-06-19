<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryBlogRequest;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CoursesCategory;
use Illuminate\Http\Request;

class CategoryBlogController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست دسته بندی های بلاگ');
        $categories = BlogCategory::GetCategories(20)->get();

        return view('panel.blogCategory.index',compact('categories'));
    }

    public function show(BlogCategory $blogCategory)
    {
        \Head::SetTitle($blogCategory->Title);

        return view('panel.blogCategory.show',compact('blogCategory'));
    }

    public function edit(BlogCategory $blogCategory)
    {
        \Head::SetTitle($blogCategory->Slug);

        return view('panel.blogCategory.edit',compact('blogCategory'));
    }

    public function create()
    {
        \Head::SetTitle('Category Blog');

        return view('panel.blogCategory.create');
    }

    public function store(CategoryBlogRequest $request)
    {
        $validateData = $request->validated();


        $blogCategory = BlogCategory::create($validateData);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The cattegoryBlog was successfully saved.'
        ];

        return  $response;


    }

    public function update(BlogCategory $blogCategory,CategoryBlogRequest $request)
    {
        $validateData = $request->validated();

        $blogCategory->update($validateData);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The cattegoryBlog was successfully update.'
        ];

        return  $response;


    }

    public function destroy(BlogCategory $blogCategory)
    {

        $category = $blogCategory;
        $isExists = BlogCategory::GetCategories(1,['parent_id'=>$category->id])->exists();

        if(!$isExists) {
            $blogs = $category->Blogs()->count();
            if ($blogs != 0) {
                $data = 'You Can not delete this category because blogs is in it,';
            } else {
                $data = 'The cattegoryBlog was successfully delete.';
                $category->delete();
            }
        }else{
            $data = 'You Can not delete this category because parent is another category.';
        }

        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }

    public function blogDestroy(Request $request)
    {
        $validateData = $request->validate([
            'categoryId' => 'required|exists:blogs_categories,id',
            'id' => 'required|exists:blogs,id'
        ]);

        $category = BlogCategory::GetCategories(1,['id'=>$validateData['categoryId']])->first();
        $blog = Blog::GetBlogs(1,['id'=>$validateData['id']])->first();
        $category->Blogs()->detach($blog);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'باگ از دسته بندی حذف شد'
        ];

        return  $response;
    }

    public function blogs(BlogCategory $blogCategory)
    {
        \Head::SetTitle($blogCategory->Title);
        $blogs = $blogCategory->Blogs;

        return view('panel.blogCategory.blogs',compact('blogs','blogCategory'));
    }
}
