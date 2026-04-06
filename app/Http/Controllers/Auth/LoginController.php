<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Role;
// use App\Models\User;
use App\Models\User;
use App\Models\VendorModel;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function authenticated(Request $request, $user) {
        // $otp = strval(rand(111111, 999999));
        $user_now = User::where('email', $user->email)->first();
        // $user_now->update([
        //     'otp' => $otp
        // ]);

        // try {
        //     Mail::to($user->email)->send(new OtpMail($otp));
        // } catch (\Exception $e) {
        //     return redirect('/verify-otp')->with('error', 'Something wrong: '.$e->getMessage());
        // }

        // return redirect('/verify-otp');
        $userRole = Role::where('id_role', Auth::user()->id_role)->first();
        Session::put([
            'user_role' => $userRole->role,
            'user_id_role' => $userRole->id_role
        ]);

        if ($userRole->id_role == 3) {
            $vendor = VendorModel::where('iduser', Auth::user()->id)->first();
            Session::put([
                'idvendor' => $vendor->idvendor
            ]);
        }

        if ($userRole->id_role == 1) {
            return redirect(route('dashboard'));
        } elseif ($userRole->id_role == 3) {
            return redirect(route('dashboard'));
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
