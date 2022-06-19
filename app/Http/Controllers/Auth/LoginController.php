<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    public function index(Request $request)
    {
        \Head::GetTitle('Login');
        $url = URL::previous();

        return view('client.auth.login',compact('url'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Email' =>['required','email'],
            'PhoneNumber' => ['required']
        ]);

        $user = User::query()->where([
            'Email'=>$data['Email']
        ])->first();

        if(empty($user))
        {
            return response()->json([
                'text' => 'no login',
                'status' => 0
            ]);
        }

        if($data["PhoneNumber"] == $user->PhoneNumber)
        {
            $this->guard()->login($user);

            return response()->json([
                'text' => 'ok lonig',
                'status' => 1
            ]);
        }
        return response()->json([
            'text' => 'no login',
            'status' => 0
        ]);


        /*if(empty($user)){
            return response()->json([
                'text' => 'no login',
                'status' => 0
            ]);
        }

        $this->guard()->login($user);

        return response()->json([
            'text' => 'ok lonig',
            'status' => 1
        ]);*/
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();
        $this->guard()->logout($user);

        $response = [
            'status' => 1,
            'text' => $user,
            "data" => $user->FirstName.' successfully logout.'
        ];

        if($request->wantsJson()){
            return response()->json($response);
        }

        return $response;
    }
}
