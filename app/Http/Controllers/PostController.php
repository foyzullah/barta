<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request):RedirectResponse
    {
        $validated = $request->validated();
        if(isset($validated['picture'])){
            $imageName = time() . '.' . $validated['picture']->extension();
            $validated['picture']->storeAs('public/images', $imageName);
        }

        Post::create([
            'description'=>$validated['description'],
            'picture'=>$imageName?? 'Null',
            'user_id'=>$request->user()->id
        ]);
        return redirect()->route('profile.show', Auth::user()->id)->with([
            'message' => 'User added successfully!',
            'status' => 'success'
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):View
    {
        $post = Post::with(['user', 'comments'])->findOrFail($id);
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        $auth_user_id = Auth::user()->id;
        if($auth_user_id !== $post->user_id){
            return redirect()->route('profile.show',$auth_user_id );
        }else{

            return view('post.edit', compact('post'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $id):RedirectResponse
    {
        $validated = $request->validated();

        if(isset($validated['picture'])){
            $imageName = time() . '.' . $validated['picture']->extension();
            $validated['picture']->storeAs('public/images', $imageName);
        }

        $post = Post::findOrFail($id);

        $post->description = $validated['description'];
        $post->picture = $imageName ?? 'Null';
        $post->save();





        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = DB::table('posts')->find($id);
        $post = Post::with('comments')->findOrFail($id);
        $auth_user_id = Auth::user()->id;

        if($auth_user_id !== $post->user_id){
            return redirect()->route('profile.show',$auth_user_id );
        }else{

            $post->delete();
            return redirect()->route('profile.show', $auth_user_id);
        }


    }
}
