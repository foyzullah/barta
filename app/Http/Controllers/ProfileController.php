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
    /**
     * Show the user's profile and user's all post.
     */

    public function show($id){
        $user = DB::table('users')->find($id);
        $posts = DB::table('posts')->where('user_id', $id)->get();
        $comments = DB::table('posts')->join('comments', 'posts.id', 'comments.post_id')->get();

        return view('profile.show', compact('user', 'posts', 'comments'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit($id): View
    {
        return view('profile.edit', [
                'user' => DB::table('users')->find($id),
            ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, String $id): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        DB::table('users')->where('id', $id)->update($validated);

        return redirect()->route('profile.show', $request->user()->id);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
