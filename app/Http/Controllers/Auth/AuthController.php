<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\BackupGlobals;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $user->save();
            return back()->with('success', 'Registration has been completed Successfully ');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
