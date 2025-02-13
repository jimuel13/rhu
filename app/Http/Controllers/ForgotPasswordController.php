<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RhuUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;



class ForgotPasswordController extends Controller
{
 // Show the forgot password form
 public function showForgotPasswordForm()
 {
     return view('auth.forgot-password');
 }

  // Send OTP email
//   public function sendOtp(Request $request)
//   {
//       $request->validate([
//           'email' => 'required|email|exists:rhu_user,email',
//       ]);

//       $user = RhuUser::where('email', $request->email)->first();

//       // Generate OTP
//       $otp = rand(100000, 999999);

//       // Store OTP in session (valid for 5 minutes)
//       Session::put('otp', $otp);
//       Session::put('email', $user->email);
//       Session::put('otp_expires', now()->addMinutes(5));

//       // Send email with OTP
//       Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
//           $message->to($user->email)
//               ->subject('Password Reset OTP');
//       });

//       return redirect()->route('password.reset')->with('success', 'OTP has been sent to your email.');
//   }





  // Show the reset password form
  public function showResetPasswordForm()
  {
      if (!Session::has('email')) {
          return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
      }

      return view('auth.reset-password');
  }

  // Handle password reset
//   public function resetPassword(Request $request)
//   {
//       $request->validate([
//           'otp' => 'required|numeric',
//           'new_password' => 'required|min:6|confirmed',
//       ]);

//       // Verify OTP
//       if ($request->otp != Session::get('otp') || now()->greaterThan(Session::get('otp_expires'))) {
//           return back()->with('error', 'Invalid or expired OTP.');
//       }

//       $user = RhuUser::where('email', Session::get('email'))->first();
//       $user->password = Hash::make($request->new_password);
//       $user->save();

//       // Clear session
//       Session::forget(['otp', 'email', 'otp_expires']);

//       return redirect()->route('login')->with('success', 'Password reset successful. Please login.');
//   }


    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:rhu_user,email',
        ]);

        $user = RhuUser::where('email', $request->email)->first();

        if (!$user) {
            session()->flash('error', 'Email not found.');
            return back()->with('error', 'Email not found.');
        }

        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('email', $user->email);
        Session::put('otp_expires', now()->addMinutes(5));

        Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset OTP');
        });

        return redirect()->route('password.reset')->with('success', 'OTP sent to your email.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($request->otp != Session::get('otp') || now()->greaterThan(Session::get('otp_expires'))) {
            session()->flash('error', 'Invalid or expired OTP.');
            return back()->with('error', 'Invalid or expired OTP.');

        }

        $user = RhuUser::where('email', Session::get('email'))->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        Session::forget(['otp', 'email', 'otp_expires']);
        session()->flash('success', 'New password created.');

        return redirect()->route('login')->with('success', 'Password reset successful. Please login.');
    }



}
