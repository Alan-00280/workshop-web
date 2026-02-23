<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class OtpController extends Controller
{
    public function show(){
        return view('verifyOtp');
    }

    public function verify(Request $request) {
        $request->validate([
            'otp' => 'required'
        ]);

        if ( $request->otp !== Auth::user()->otp ) {
            return back()->with('error', 'Kode OTP Salah!');
        }

        Auth::user()->update([
            'otp' => null
        ]);

        $userRole = Role::where('id_role', Auth::user()->id_role)->first();
        Session::put([
            'user_role' => $userRole->role,
            'user_id_role' => $userRole->id_role
        ]);

        return redirect(route('dashboard'));
    }
}
