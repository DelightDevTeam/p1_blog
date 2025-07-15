<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\CommentController;
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
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\UserPostController::class, 'index'])->name('user_home');
Route::get('/postsdetail/{id}', [App\Http\Controllers\UserPostController::class, 'show'])->name('postsdetail.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::post('/profile/picture', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::resource('categories', CategoryController::class); // 7 methods, index, create, store, edit, update, destroy
Route::resource('posts', PostController::class); // 7 methods, index, create, store, edit, update, destroy

// Comment routes
Route::prefix('comments')->group(function () {
    Route::get('/post/{postId}', [CommentController::class, 'getPostComments'])->name('comments.post');
    Route::post('/', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/{comment}/like', [CommentController::class, 'toggleLike'])->name('comments.like');
});

// admin master page route 
// Route::get('/admin', function () {
//     return view('admin.dashboard');
// });
