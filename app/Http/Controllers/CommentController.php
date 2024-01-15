<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{


    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'comment'=> 'required | max:100'
        ]);


        Comment::create([
            'post_id'=> $id,
            'user_id'=>auth()->user()->id,
            'comment'=>$validated['comment']
        ]);


        return redirect()->route('posts.show', $id);
    }

    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id);
        return view('comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'comment'=>'required',
            'post_id'=>'string',
            'user_id'=>'string'
        ]);
        $comment = Comment::findOrfail($id);
        $comment->comment = $validated['comment'];
        $comment->save();

        return Redirect::to(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comment::findOrFail($id)->delete();
    }
}
