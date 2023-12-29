<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $imageName = time() . '.' . $validated['picture']->extension();
        $validated['picture']->storeAs('public/images', $imageName);

        DB::table('posts')->insert([
            'description'=>$validated['description'],
            'image_url'=>$imageName,
            'user_id'=>Auth::user()->id
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
        // $auth_user = Auth::user()->id;
        // $user_id = DB::table('posts')->where('user_id', $auth_user);
        // if($auth_user !== $user_id){

        // }


        // $posts = DB::table('posts')->join('users', function (JoinClause $join) use ($id){
        //     $join->on('users.id', '=', 'posts.user_id')->where('id', $id);
        // } )->first();

        $post = DB::table('posts')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->select('posts.*', 'users.first_name as first_name','users.last_name as last_name' , 'users.email as user_email')
        ->where('posts.id', '=', $id)
        ->first();
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = DB::table('posts')->find($id);
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
        $imageName = time() . '.' . $validated['picture']->extension();
        $validated['picture']->storeAs('public/images', $imageName);

        DB::table('posts')->where('id', $id)->update([
            'description'=> $validated['description'],
            'image_url'=>$imageName
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = DB::table('posts')->find($id);
        $auth_user_id = Auth::user()->id;

        if($auth_user_id !== $post->user_id){
            return redirect()->route('profile.show',$auth_user_id );
        }else{

            DB::table('posts')->where('id', $id)->delete();
            return redirect()->route('profile.show', $auth_user_id);
        }


    }
}
