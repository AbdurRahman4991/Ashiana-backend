<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\AuthRepositoryInterface;

class AuthController extends Controller
{
    private $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(Request $request)
    {

        $request->validate([
            'pharmacy_name' => 'required',
            'contact_no' => 'required|unique:users',
            'name' => 'required',
            'address' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = $this->authRepository->register($request->all());

        return response()->json([
            'status' => true,
            'message' => 'User Registered Successfully',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'contact_no' => 'required',
            'password' => 'required'
        ]);

        $user = $this->authRepository->login($request->all());

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials'
            ],401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login Success',
            'token' => $token,
            'user' => $user
        ]);
    }
}
