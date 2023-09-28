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
   Route::post('comment/store','store')->name('comments.store');
   Route::get('comments/{post_id}','index')->name('comments');
   Route::put('comment/update/{id}','update')->name('comments.update');
   Route::delete('comment/delete/{id}','delete')->name('comments.delete');
   Route::post('comment/like')->name('comment.like');
});

Route::middleware('jwt.verify')->controller(ReplyController::class)->group(function(){
   Route::post('reply/store','store')->name('replies.store');
   Route::get('replies/{comment_id}','index')->name('replies');
   Route::put('reply/update/{id}','update')->name('replies.update');
   Route::delete('reply/delete/{id}','delete')->name('replies.delete');
   Route::post('reply/like','like')->name('reply.like');
});

Route::middleware('jwt.verify')->controller(ReplyReplyController::class)->group(function(){
    Route::post('replyreply/store','store')->name('reply_replies.store');
    Route::get('replyreplies/{reply_id}','index')->name('reply_replies');
    Route::put('replyreply/update/{id}','update')->name('reply_replies.update');
    Route::delete('replyreply/delete/{id}','delete')->name('reply_replies.delete');
    Route::post('replyreply/like','like')->name('reply_replies.like');
});

Route::middleware('jwt.verify')->controller(UserController::class)->group(function(){
   Route::post('user/follow','follow')->name('users.follow');
   Route::post('user/block','block')->name('users.block');
});

Route::middleware(['jwt.verify','admin'])->controller(AdminController::class)->group(function(){
   Route::post('admin/block')->name('admins.block');
});

Route::middleware(['jwt.verify','admin'])->controller(CategoryController::class)->group(function(){
    Route::post('category/store','store')->name('categories.store');
    Route::get('categories','index')->name('categories');
    Route::put('category/update/{id}','update')->name('categories.update');
    Route::delete('category/delete/{id}','delete')->name('categories.delete');
});
