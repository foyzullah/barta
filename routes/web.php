<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     if(auth()->user()){
//         return view('dashboard');
//     }
//     return redirect()->route('login');
// });

Route::get('/', function () {
    $posts=DB::table('users')->join('posts', 'posts.user_id', 'users.id')->get();
    $comments = DB::table('posts')->join('comments', function (JoinClause $join){
        $join->on('posts.id', '=', 'comments.post_id');
    })->get();
    return view('home.newsfeed', compact('posts', 'comments'));

})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('posts', PostController::class);
    Route::post('comment/post/{postId}', [CommentController::class, 'store'])->name('comment.store');
    Route::get('comment/{id}', [CommentController::class, 'edit'])->name('comment.edit');
    Route::patch('comment/{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

require __DIR__.'/auth.php';
