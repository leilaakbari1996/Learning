<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CartController as CartApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
    public function store(CartRequest $request)
    {
        if (!auth()->check()){
            $response = [
                'status' => 0,
                'text' => "no Login",
                'data' => 'login'

            ];
            return $response;
        }
        \Head::SetTitle('Cart');

        CartApi::AddToCart($request);


        $response = [
            'status' => 1,
            'text' => '',
            "data" => 'add to cart'
        ];

        return  $response;



    }

    public function update(CartRequest $request)
    {
        $user = auth()->user();
        CartApi::EditCart($request,$user);
    }

    public function destroy(CartRequest $request)
    {
        $user = auth()->user();
        CartApi::DestroyCart($request,$user);
    }

    public function destroyAll(Request $request)
    {
        $user = auth()->user();
        CartApi::DestroyAllCart($request,$user);
    }

    public static function GetCourses(Request $request,User $user)
    {

        $courses = $user->CoursesInCart;

        $response = [
            'status' => 1,
            'text' => "succsfull",
            'data' => $courses

        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function GetVideos(Request $request,User $user)
    {
        $videos= $user->VideosInCart;

        $response = [
            'status' => 1,
            'text' => "succsfull",
            'data' => $videos

        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function AddToCart(Request $request)
    {
        if(!auth()->check()){
            return redirect('login');
        }
        $user = auth()->user();
        $validateData = $request->validated();
        if($validateData['model'] == 'Course'){
            $isCheck = $user->CoursesInCart()->where('cartable_id',$validateData['id'])->exists();//This Course exists In cart.
            if($isCheck){
                $user->CoursesInCart()->detach($validateData['id']);
                $user->CoursesInCart()->attach($validateData['id'],[
                    'Count' => $validateData['count']
                ]);
            }else{
                $user->CoursesInCart()->attach($validateData['id'],[
                    'Count' => $validateData['count']
                ]);
            }

        }else if($validateData['model'] == 'Video'){
            $isCheck = $user->VideosInCart()->where('cartable_id',$validateData['id'])->exists();//This Videosexists In cart.
            if($isCheck){
                $user->VideosInCart()->detach($validateData['id']);
                $user->VideosInCart()->attach($validateData['id'],[
                    'Count' => $validateData['count']
                ]);
            }else{
                $user->VideosInCart()->attach($validateData['id'],[
                    'Count' => $validateData['count']
                ]);
            }
        }

        $response = [
            'status' => 1,
            'text' => "succsfull",

        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function EditCart(Request $request,User $user)
    {
        $validateData = $request->validated();
        if($validateData['model'] == 'Course'){
            $isExists = $user->checkExistsCourse($validateData['id']);
            if($isExists){
                $user->CoursesInCart()->syncWithPivotValues($validateData['id'],['Count' => $validateData['count']]
                );
            }else{
                abort(403);
            }

        }else if($validateData['model'] == 'Video'){
            $isExists = $user->checkExistsVideo($validateData['id']);
            if($isExists){
                $user->VideosInCart()->syncWithPivotValues($validateData['id'],['Count' => $validateData['count']]
                );
            }else{
                abort(403);
            }
        }

        $response = [
            'status' => 1,
            'text' => "succsfull",

        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function DestroyCart(Request $request,User $user)
    {
        $validateData = $request->validated();
        if($validateData['model'] == 'Course'){
            $isExists = $user->checkExistsCourse($validateData['id']);
            if($isExists){
                $user->CoursesInCart()->detach($validateData['id'],['Count' => $validateData['count']]
                );
            }else{
                abort(403);
            }

        }else if($validateData['model'] == 'Video'){
            $isExists = $user->checkExistsVideo($validateData['id']);
            if($isExists){
                $user->VideosInCart()->detach($validateData['id']);
            }else{
                abort(403);
            }
        }

        $response = [
            'status' => 1,
            'text' => "succsfull",

        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }

    public static function DestroyAllCart(Request $request,User $user)
    {
        if(!$request->get('model')){
            $user->CoursesInCart()->detach();
            $user->VideosInCart()->detach();
        }else {
            if ($request->get('model') == 'Course') {
                $user->CoursesInCart()->detach();
            } else if ($request->get('model') == 'Video') {
                $user->VideosInCart()->detach();

            }
        }
        $response = [
            'status' => 1,
            'text' => "succsfull",
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;

    }
    /*****end*/











}
