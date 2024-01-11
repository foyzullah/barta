<?php

namespace App\Http\Controllers;

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


        DB::table('comments')->insert([
            'post_id'=> $id,
            'user_id'=>auth()->user()->id,
            'comment'=>$validated['comment']
        ]);


        return redirect()->route('posts.show', $id);
    }

    public function edit(string $id)
    {
        $comment = DB::table('comments')->find($id);
        return view('comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'comment'=>'required',
            'post_id'=>'string',
            'user_id'=>'string'
        ]);
        DB::table('comments')->where('id', $id)->update($validate);

        return Redirect::to(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('comments')->where('id', $id)->delete();
    }
}
