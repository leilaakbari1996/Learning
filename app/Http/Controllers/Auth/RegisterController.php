<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use AuthenticatesUsers;

    public function index()
    {
        return view('client.auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->create([
            'LastName' => $data['LastName'],
            'FirstName' => $data['FirstName'],
            'Email' => $data['Email'],
            'PhoneNumber' => $data['PhoneNumber'],
            'IsAdmin' => 0
        ]);

        $this->guard()->login($user);

        return response()->json([
            'text' => $user
        ]);
    }
}
