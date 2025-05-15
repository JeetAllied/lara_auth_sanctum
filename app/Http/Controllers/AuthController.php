<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\LoginUserRequest;
use App\Http\Requests\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->error(null, 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
        ], 'User Logged In Successfully', 200);
    }
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
        ], 'User Created Successfully', 201);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'User Logged Out Successfully', 200);
    }
}
