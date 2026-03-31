<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\OtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,contact_no'
        ]);

        $user = User::where('contact_no', $request->phone)->first();

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // SMS পাঠানো
        $this->sendSms($request->phone, $otp);

        return response()->json([
            'message' => 'OTP sent successfully'
        ], 200);
    }

   private function sendSms($phone, $otp)
   {
       $phone = $this->formatPhone($phone);

       $message = "Your MyApp OTP is $otp";

       try {
           $response = Http::get(config('services.sms.url'), [
               'api_key' => config('services.sms.api_key'),
               'type' => 'text',
               'number' => $phone,
               'senderid' => config('services.sms.sender'),
               'message' => $message,
           ]);

           \Log::info('SMS API Response: ' . $response->body());

           return $response->body();

       } catch (\Exception $e) {
           \Log::error('SMS Error: ' . $e->getMessage());
           return false;
       }
   }
    private function formatPhone($phone)
    {
        // যদি already 880 দিয়ে শুরু হয়
        if (strpos($phone, '880') === 0) {
            return $phone;
        }

        // যদি 01 দিয়ে শুরু হয়
        if (strpos($phone, '01') === 0) {
            return '88' . $phone;
        }

        return $phone;
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

        // ✅ FIX HERE
        $user->password = Hash::make($request->password);

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
