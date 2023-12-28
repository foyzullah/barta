<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function show(string $id):View
    {

        $user = DB::table('users')->find($id);
        $posts = DB::table('posts')->where('user_id', $id)->get();

        // $user = DB::table('users')
        // ->join('posts', 'users.id', '=', 'posts.user_id')
        // ->where('users.id', $id)
        // ->get();

        // dd($user);


        return view('profile.show', compact(['user', 'posts']));
    }

    public function edit(string $id):View
    {
        $user = DB::table('users')->find($id);
        return view('profile.edit', ['user'=> $user]);

    }

    public function update(ProfileUpdateRequest $request):RedirectResponse
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $user = DB::table('users')->where('id', $id)->update([

            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name']
        ]);

        return redirect()->route('profile.show', auth()->user()->id);
    }

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.create');
    }
}
