<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
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

Route::get('/', function (Request $request) {

    $searchItem = $request->input('search');

    if($searchItem){

        $user = User::whereRaw("concat(first_name, ' ', last_name) like '%".$searchItem."%'")
                    ->orWhere('email','like', '%'. $searchItem .'%')->first();
        $posts = Post::where('user_id', $user->id)->with(['comments', 'user'])->latest()->get();
    }else{

        $posts = Post::with(['user', 'comments'])->latest()->get();
    }
    return view('home.newsfeed', compact('posts'));

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


    Route::get('/search', [SearchController::class, 'search'])->name('search');
});

require __DIR__.'/auth.php';
