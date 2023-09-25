<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\CommentController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\ReplyController;
use App\Http\Controllers\api\ReplyReplyController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('jwt.verify')->controller(PostController::class)->group(function(){
    Route::post('posts/store','store')->name('posts.store');
    Route::get('posts','index')->name('posts');
    Route::get('post/{id}','show')->name('post');
    Route::put('post/update/{id}','update')->name('posts.update');
    Route::delete('post/delete/{id}','delete')->name('posts.delete');
    Route::post('post/like')->name('post.like');
});

Route::middleware('jwt.verify')->controller(CommentController::class)->group(function(){
   Route::post('comments/store','store')->name('comments.store');
   Route::get('comments/{post_id}','index')->name('comments');
   Route::put('comments/update/{id}','update')->name('comments.update');
   Route::delete('comments/delete/{id}','delete')->name('comments.delete');
   Route::post('comment/like')->name('comment.like');
});

Route::middleware('jwt.verify')->controller(ReplyController::class)->group(function(){
   Route::post('replies/store','store')->name('replies.store');
   Route::get('replies/{comment_id}','index')->name('replies');
   Route::put('replies/update/{id}','update')->name('replies.update');
   Route::delete('replies/delete/{id}','delete')->name('replies.delete');
   Route::post('reply/like','like')->name('reply.like');
});

Route::middleware('jwt.verify')->controller(ReplyReplyController::class)->group(function(){
    Route::post('replyreplies/store','store')->name('reply_replies.store');
    Route::get('replyreplies/{reply_id}','index')->name('reply_replies');
    Route::put('replyreplies/update/{id}','update')->name('reply_replies.update');
    Route::delete('replyreplies/delete/{id}','delete')->name('reply_replies.delete');
    Route::post('replyreply/like','like')->name('reply_replies.like');
});

Route::middleware('jwt.verify')->controller(UserController::class)->group(function(){
   Route::post('users/follow','follow')->name('users.follow');
   Route::post('users/block','block')->name('users.block');
});

Route::middleware(['jwt.verify','admin'])->controller(AdminController::class)->group(function(){
   Route::post('admins/block')->name('admins.block');
});

Route::middleware(['jwt.verify','admin'])->controller(CategoryController::class)->group(function(){
    Route::post('categories/store','store')->name('categories.store');
    Route::get('categories/{comment_id}','index')->name('categories');
    Route::put('categories/update/{id}','update')->name('categories.update');
    Route::delete('categories/delete/{id}','delete')->name('categories.delete');
});
