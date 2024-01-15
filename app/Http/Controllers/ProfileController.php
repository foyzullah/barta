<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
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

        $user = User::with(['posts', 'comments'])->findOrFail($id);
        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit($id): View
    {

        $user = User::findOrFail($id);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, String $id): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $validated = $request->validated();

        if(isset($validated['picture'])){
            $imageName = time() . '.'. $validated['picture']->extension();
            $validated['picture']->storeAs('public/avatars', $imageName);
        }

        $validated['picture']= $imageName;

        User::where('id', $id)->update($validated);

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
