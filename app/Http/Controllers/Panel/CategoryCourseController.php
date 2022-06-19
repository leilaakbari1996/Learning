<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CategoryCourseRequest;
use App\Models\BlogCategory;
use App\Models\CoursesCategory;
use Illuminate\Http\Request;

class CategoryCourseController extends Controller
{
    public function index()
    {
        \Head::SetTitle('Category Course');

        $categories = CoursesCategory::GetCategory()->get();

        return  view('panel.categoryCourse.index',compact('categories'));
    }

    public function show(CoursesCategory $coursesCategory)
    {
        $category = $coursesCategory;
        \Head::SetTitle($category->Slug);

        return view('panel.categoryCourse.show',compact('category'));
    }

    public function create()
    {
        \Head::SetTitle('ایجاد دسته بندی دوره ها');

        return view('panel.categoryCourse.create');
    }

    public function store(CategoryCourseRequest $request)
    {
        $validataData = $request->validated();

        $courseCategory = CoursesCategory::create($validataData);

        $response = [
            'status' => 1,
            'text' => $courseCategory,
            "data" => 'The blogcourseCategory was successfully saved.'
        ];

        return  $response;
    }

    public function edit(CoursesCategory $coursesCategory)
    {
        \Head::SetTitle($coursesCategory->Title);

        return view('panel.categoryCourse.edit',compact('coursesCategory'));
    }

    public function update(CoursesCategory $courseCategory,CategoryCourseRequest $request)
    {
        $validataData = $request->validated();

        $courseCategory->update($validataData);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The courseCategory was successfully update.'
        ];

        return  $response;
    }

    public function destroy(CoursesCategory $category, Request $request)
    {
        //--------------- <editor-fold description="!parent_id other CategoryCourse && !courses">--------------//
        $isExists = CoursesCategory::GetCategory(['parent_id'=>$category->id])->exists();
        if(!$isExists) {
            $courses = $category->Courses()->count();
            if ($courses != 0) {
                $data = 'You Can not delete this category because courses is in it,';
            } else {
                $data = 'The categoryCourses was successfully delete.';
                $category->delete();
            }
        }else{
            $data = 'You Can not delete this category because parent is another category.';
        }
        //---------------- </editor-fold> -------------------------//


        $response = [
            'status' => 1,
            'text' => "",
            "data" => $data
        ];

        return  $response;
    }
}
