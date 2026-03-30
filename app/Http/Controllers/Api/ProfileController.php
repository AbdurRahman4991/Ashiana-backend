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
        ]);

        $data = $request->only(['name', 'pharmacy_name', 'contact_no', 'address']);

        $user = $this->userService->updateProfile(Auth::id(), $data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed', // new_password_confirmation ফিল্ড লাগবে
        ]);

        $userId = Auth::id();

        $result = $this->userService->changePassword(
            $userId,
            $request->old_password,
            $request->new_password
        );

        return response()->json($result);
    }
}
