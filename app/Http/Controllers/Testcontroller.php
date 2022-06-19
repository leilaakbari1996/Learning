<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Comment;
use App\Models\Course;
use App\Models\CoursesCategory;
use App\Models\Guidance;
use App\Models\Podcast;
use App\Models\User;
use Illuminate\Http\Request;

class Testcontroller extends Controller
{
    public function index()
    {



        //$specialProducts = \Api\Products\SpecialProducts();
        $array = [];
        $arrayCategories = [];
        $mainarray = collect([]);
        $courses = Course::Most('Likes');
        foreach ($courses as $course){
            $categories = $course->Categories;
            foreach ($categories as $category){
                if(!in_array($category->id,$array)){
                    $array[] = $category->id;
                    $mainarray->push($category);

                }
            }
        }

        foreach($mainarray as $category) {
            foreach ($courses as $course) {
                $categories = $course->Categories;
                foreach ($categories as $categoryMain) {
                    if ($category->id == $categoryMain->id) {
                        $arrayCategories [][] = $course;
                    }
                }
            }
        }
        $title = 'cource';
        return view('test',compact('arrayCategories','title','mainarray'));
    }
    public function show(){

        $course = Course::query()->where("id",1)->with([
            "Masters" => function($q){
                $q->select(["Description","ProfileURL","FirstName","LastName"]);
            },
            "Tags" => function($q){
                $q->limit(2);
            },
            "RelatedCourse"=>function($q){
                $q->select(['Title','Slug']);
            },


        ])->first();

        /*foreach ($course->RelatedCourse as $item)
        {
            echo $item->Title.'<br>';
        }*/

        $relatedCourses = collect([]);


        $relatedCourses = $course->RelatedCourse;

        if(count($relatedCourses) < 5)
        {
            $count = 6 - count($relatedCourses);

            $courseByCat = Course::RelatedCourseByCategory($course, $count);

            $relatedCourses = $relatedCourses->merge($courseByCat);
        }
        foreach ($relatedCourses as $relatedCourse){

            echo $relatedCourse->Title.'<br>';
        }



//        dd("PK");
//        $user = User::query()->where('IsMaster',true)->first();
//
//        dd($user->CoursesByMaster);



    }

    public function create(){
        /*comments
       $course = Course::find(1);
        $comments = $course-> Comments();



        foreach ($comments as $comment){
            echo $comment[0]->Text.'<br>';
            if(array_key_exists(1,$comment)){
                echo $comment[1]->Text.'<br><br>';
            }

        }*/
        $course = Podcast::find(1);
        $user = User::find(1);
        $course->changeSave($user);


    }
}
