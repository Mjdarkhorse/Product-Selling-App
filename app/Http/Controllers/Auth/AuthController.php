<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\ResetPasswordpassword_reset_token;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\BackupGlobals;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Nette\Utils\Random;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function registerView()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }

    public function register(RegisterRequest $request)
    {
        // dd($request->all());
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_no = $request->phone;
            $user->country_code = $request->code;
            $user->password = Hash::make($request->password);
            $user->verification_token = Str::random(60);
            $user->token_expires_at = Carbon::now()->addHour();
            $user->save();
            $this->sendVarificationaMail($user);
            return back()->with('success', 'Registration has been completed Successfully,Please Check your mail and vrify your account ! ');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    protected function sendVarificationaMail($user)
    {
        $verificationUrl = url('/verify/' . $user->verification_token);
        Mail::send(
            'mails.verification',
            ['name' => $user->name, 'url' => $verificationUrl],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Varification Mail');
            }
        );
    }
    public function loginView()
    {
        try {
            return view('auth.login');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }
    public function login(LoginRequest $request)
    {
        try {
            $userCredentials = $request->only('email', 'password');
            if (Auth::attempt($userCredentials)) {
                if (Auth::user()->Is_varified == 0) {
                    Auth::logout();
                    return back()->with('error', 'Verify Your Email !!');
                }
                if (Auth::user()->is_admin == 1) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('user.dashboard');
                }
            } else {
                return back()->with('error', 'User & Password Incorrect');
            }

            return back()->with('success', 'Login Successful !!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function forget_PasswordView()
    {
        try {
            return view('auth.forgetPassword');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }
    public function forget_Password(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->with('error', 'Email is not exits !!');
            }
            $token = Str::random(40);
            $url = url('/reset-password/' . $token);
            ResetPasswordpassword_reset_token::updateOrInsert([
                'email' => $user->email
            ], [
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            // DB::table('password_reset_tokens')->updateOrInsert(
            //     ['email' => $user->email], // Condition
            //     [
            //         'email' => $user->email,
            //         'token' => $token,
            //         'created_at' => Carbon::now(),
            //     ]
            // );
            Mail::send('mails.forget_password', ['url' => $url], function ($message) use ($user) {
                $message->to($user->email)->subject('Reset Password');
            });
            return back()->with('success', 'Reset Password link sent to your mail !!');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }

    public function resetPasswordView($token)
    {
        try {
            $resetPass = ResetPasswordpassword_reset_token::where('token', $token)->first();
            if (!$resetPass) {
                return abort(404, "Something went wrong");
            }
            $user = User::where('email', $resetPass->email)->first();
            return view('auth.resetPassword', compact('user'));
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();
            ResetPasswordpassword_reset_token::where('email', $user->email)->delete();
            return redirect()->route('updatePassword');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }
    public function updatePassword()
    {
        try {
            return view('auth.updatePassword');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }
}
