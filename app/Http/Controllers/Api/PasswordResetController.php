<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\OtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['phone' => 'required|exists:users,contact_no']);

        $user = User::where('contact_no', $request->phone)->first();
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        $user->notify(new OtpNotification($otp));

        return response()->json(['message' => 'OTP sent successfully'], 200);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,contact_no',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('contact_no', $request->phone)->first();

        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        return response()->json(['message' => 'OTP verified'], 200);
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,contact_no',
            'password' => 'required|string|min:6',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('contact_no', $request->phone)->first();

        if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        $user->password = $request->password;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
