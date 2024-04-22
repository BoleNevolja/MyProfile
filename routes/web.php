<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search']);
Route::get('/hotposts', [App\Http\Controllers\HomeController::class, 'hotposts'])->name("hotposts");
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'adminview'])->name("admin");
Route::get('/admin/users', [App\Http\Controllers\HomeController::class, 'adminusers']);
Route::get('/followed/users/{id}', [App\Http\Controllers\HomeController::class, 'followedusers'])->name("followed.users");

Route::post('/post', [App\Http\Controllers\PostController::class, 'store']);
Route::delete('/post/delete/{id}', [App\Http\Controllers\PostController::class, 'destroy']);
Route::put('/post/edited/{id}', [App\Http\Controllers\PostController::class, 'update']);
Route::put('/post/verify/{id}', [App\Http\Controllers\PostController::class, 'verify']);
Route::put('/post/unverify/{id}', [App\Http\Controllers\PostController::class, 'unverify']);
Route::get('/post/{id}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name("post");
Route::get('/post/{id}/edited', [App\Http\Controllers\PostController::class, 'edit'])->name("post");
Route::get('/post/{id}', [App\Http\Controllers\PostController::class, 'index']);

Route::post('/post/{id}/comment', [App\Http\Controllers\CommentController::class, 'store']);
Route::get('/comment/{id}/edit', [App\Http\Controllers\CommentController::class, 'edit']);
Route::put('/comment/{id}/edited', [App\Http\Controllers\CommentController::class, 'update']);
Route::delete('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'destroy']);

Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'index'])->name("user");
Route::get('/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name("edit");
Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update']);
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth');
Route::put('/addadmin/{id}', [App\Http\Controllers\UserController::class, 'admin']);
Route::put('/removeadmin/{id}', [App\Http\Controllers\UserController::class, 'removeadmin']);
Route::get('/get-owner-bdg/{id}', [App\Http\Controllers\UserController::class, 'getownerbdg']);
Route::put('/owner-bdg/{id}', [App\Http\Controllers\UserController::class, 'owner']);
Route::get('/get-admin-bdg/{id}', [App\Http\Controllers\UserController::class, 'getadminbdg']);
Route::put('/admin-bdg/{id}', [App\Http\Controllers\UserController::class, 'admine']);
Route::get('/suprise', [App\Http\Controllers\UserController::class, 'suprise']);
Route::get('/user/{user}', 'UserController@show')->name('user.show');

Route::post('/follow/user', [App\Http\Controllers\FollowerController::class, 'follow'])->middleware('auth')->name("users.follow");
Route::post('/unfollow/user', [App\Http\Controllers\FollowerController::class, 'unfollow'])->middleware('auth')->name("users.unfollow");
Route::get('/followers/{id}', [App\Http\Controllers\FollowerController::class, 'index']);

Route::post('/like/post', [App\Http\Controllers\LikeController::class, 'like'])->middleware('auth')->name("post.like");
Route::post('/unlike/{post}', [App\Http\Controllers\LikeController::class, 'unlike'])->middleware('auth')->name("post.unlike");
Route::get('/liked/posts/{user}', [App\Http\Controllers\LikeController::class, 'index'])->middleware('auth')->name("liked.posts");
Route::get('/likes/{id}', [App\Http\Controllers\LikeController::class, 'likes'])->middleware('auth');

Route::post('/addmsg', [App\Http\Controllers\BoardController::class, 'store']);