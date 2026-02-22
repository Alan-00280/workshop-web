<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Symfony\Component\HttpFoundation\Response;

class isAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (Session::get('user_id_role') == null) {
            Session::forget(['user_role', 'user_id_role']);
            Auth::logout();
            return redirect('/login');
        }    

        if (!Auth::check()) {
            Session::forget(['user_role', 'user_id_role']);
            Auth::logout();
            return redirect('/login');
        }
        
        // dd(Session::get('user_id_role'));
        if (Session::get('user_id_role') !== 1) {
            return back()->with('error', 'Akses Ditolak!');
        }


        return $next($request);
    }
}
