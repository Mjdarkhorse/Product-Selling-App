<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\BackupGlobals;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registerView()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            return abort_if(404, "Something went wrong");
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
            return abort_if(404, "Something went wrong");
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
}
