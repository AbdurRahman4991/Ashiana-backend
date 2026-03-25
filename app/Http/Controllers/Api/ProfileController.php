<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

     public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pharmacy_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'address' => 'required|string|max:255',
           // 'password' => 'nullable|string|min:6',
        ]);

        $data = $request->only(['name', 'pharmacy_name', 'contact_no', 'address', 'password']);

        $user = $this->userService->updateProfile(Auth::id(), $data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}
