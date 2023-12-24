<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function registerForm() {
        return view( 'user.register' );
    }

    public function register( Request $request ) {

        DB::table( 'users' )->insert( [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make( $request->password ),
        ] );

        return redirect()->route( 'login' );
    }

    public function loginForm() {
        return view( 'user.login' );
    }

    public function login( Request $request ) {
        $credentials = $request->validate( [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ] );
        if ( Auth::attempt( $credentials ) ) {
            $request->session()->regenerate();

            return redirect()->route( 'profile.index' );
        }

        return back()->withErrors( [
            'email' => 'The provided credentials do not match our records.',
        ] )->onlyInput( 'email' );
    }

}
