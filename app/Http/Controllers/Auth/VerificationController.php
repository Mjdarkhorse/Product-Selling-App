<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request, $token)
    {
        $user = User::where('verification_token', $token)->first();
        if (!$user) {
            return abort(404, "Something Went Wrong !!");
        }
        if ($user->token_expires_at < Carbon::now()) {
            $msg = "Verification token has expired.";
            return view('auth.verification-message', compact('msg'));
        }
        $user->Is_varified = 1;
        $user->email_verified_at = Carbon::now();
        $user->verification_token = null;
        $user->token_expires_at = null;
        $user->save();
        $msg = "Mail Verification Successfully Completed";
        return view('auth.verification-message', compact('msg'));
    }
}
