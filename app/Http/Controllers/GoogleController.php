<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Session;
// use \Laravel\Socialite\Socialite;

class GoogleController extends Controller
{
    function redirect() {
        return Socialite::driver('google')->with(['prompt' => 'consent'])->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()], // cari ada tidak
            [
                'name' => $googleUser->getName(),
                'id_google' => $googleUser->getId(),
                'password' => password_hash( \strval(rand(111111, 99999)), PASSWORD_DEFAULT),
                'id_role' => 1
            ] // update ataw create
        );

        $otp = rand(111111, 999999);
        $user->update([
            'otp' => $otp
        ]);

        Auth::login($user);
        Mail::to($user->email)->send(new OtpMail($otp));
        return redirect('/verify-otp');
    }
}
