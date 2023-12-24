<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function create(){
        return view('auth.register');
    }

    public function store(RegistrationRequest $request){
        $validated = $request->validated();
        DB::table('users')->insert([
            'first_name'=>$validated['first_name'],
            'last_name'=> $validated['last_name'],
            'email'=> $validated['email'],
            'password'=> Hash::make($validated['password'])
        ]);
        return redirect()->route('login.create');

    }
}
