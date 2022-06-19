<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\CoursesCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\HomeController as HomeApi;
use \App\Http\Controllers\Api\BannerController as BannerApi;
use \App\Http\Controllers\Api\CourseController as CourseApi;
use \App\Http\Controllers\Api\CourseCategoryController as CategoryCourseApi;
use \App\Http\Controllers\Api\GuidanceController as GuidanceApi;
use \App\Http\Controllers\Api\BlogController as BlogApi;
use \App\Http\Controllers\Api\PodcastController as PodcastApi;
use \App\Http\Controllers\Api\UserController as UserApi;
use \App\Http\Controllers\Api\SettingsController as SettingsApi;
use \App\Http\Controllers\Api\BlogCategoryController as BlogCategoryApi;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('LexonTech');
        $banners = BannerApi::BannerEnable($request,3,['IsEnable'=>true])['data'];
        $specialCourses = CourseApi::GetSpecialCourses($request,5)['data'];
        $specialCategories =CategoryCourseApi::GetSpecialCategory($request,5)['data'];
        $freeCourses = CourseApi::GetAllCoursesByColumn($request,$specialCategories,'IsFree',5)['data'];// Get Courses Free According Categories Special.
        $newCourses = CourseApi::GetAllCoursesByColumn($request,$specialCategories,'IsNew',5)['data'];//Get Courses Free According Categories Special.
        $mostSoldCourses = CourseApi::GetTheMost($request,$specialCategories,'NumberOfBuys',5)['data'];//Get The Most Courses Sold.
        $categories = CategoryCourseApi::GetCategories($request,10)['data'];//Get All Categorires => IsEnable = true
        $guidancesSpecial = GuidanceApi::GetGuidanceSpecial($request,5)['data'];//Get Guidances Special
        $categoriesBlog = BlogCategoryApi::GetBlogCategories($request,10,['IsSpecial' => true])['data'];
        $blogsNew = BlogApi::GetBlog($request,5,['IsNew'=>true])['data'];//Get Blogs New
        $podcastsSpecial = PodcastApi::GetPodcast($request,5,['IsSpecial' => true])['data'];//Get podcast Special
        $masters = UserApi::GetUsersByRole($request,10,['IsMaster' => true])['data'];//Get Masters This Site
        $settings = SettingsApi::GetSettings($request)['data'];

        return view("client.index",compact("settings","banners",'specialCategories','guidancesSpecial'
        ,'freeCourses','specialCourses','categories','newCourses','mostSoldCourses','specialCategories'
            ,'blogsNew','podcastsSpecial','masters','categoriesBlog'));
    }

}
