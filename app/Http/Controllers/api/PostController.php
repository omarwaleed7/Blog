<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostView;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class PostController extends Controller
{
    // trait for api response
    use ApiResponseTrait;

    // store a post
    public function store(PostRequest $request){
        $post=Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>Auth()->User()->id,
            'category_id'=>$request->category_id,
        ]);
        return $this->apiResponse($post,'Post stored successfully',201);
    }

    // show all posts
    public function index(){
        $posts=Post::all();
        //check if posts
        if($posts){
            return $this->apiResponse($posts,'Posts retrieved successfully',200);
        }
        else{
            return $this->apiResponse(null,'Posts not found',404);
        }
    }

    // show a post
    public function show($id){
        $post=Post::find($id);

        // check if post
        if($post){
            // checks if user isn't post owner
            if(Auth()->User()->id!==$post->user_id){
                // using view method
                $this->view($id);
            }
            return $this->apiResponse($post,'Post retrieved successfully',200);
        }
        else{
            return $this->apiResponse(null,'Post not found',404);
        }
    }

    // update a post
    public function update(PostRequest $request,$id){
        $post=Post::find($id);

        // check if post
        if($post){

            // check if user isn't post owner
            if(Auth()->User()->id!==$post->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $post->update([
                'title'=>$request->title,
                'body'=>$request->body,
                'category_id'=>$request->category_id,
            ]);
            $updated_post=Post::find($id);
            return $this->apiResponse($updated_post,'Post updated successfully',200);
        }
        else{
            return $this->apiResponse(null,'Post not found',404);
        }
    }

    // delete a post
    public function delete($id){
        $post=Post::find($id);

        // check if post
        if($post){

            // check if user isn't post owner
            if(Auth()->User()->id!==$post->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $post->delete();
            return $this->apiResponse(null,'Post deleted successfully',204);
        }
        else{
            return $this->apiResponse(null,'Post not found',404);
        }
    }

    // store a post view
    public function view($id){
        PostView::create([
            'user_id'=>Auth()->User()->id,
            'post_id'=>$id
        ]);
    }
    // store a like
    public function like(PostRequest $request){

        // check if user already liked post
        $existing_like = PostLike::where('user_id', Auth()->User()->id)
            ->where('post_id', $request->post_id)
            ->first();

        // if like exists
        if($existing_like){
            $existing_like->delete();
            return $this->apiResponse(null,'Post unliked successfully',200);
        }
        $like=PostLike::create([
            'user_id'=>Auth()->User()->id,
            'post_id'=>$request->post_id
        ]);
        return $this->apiResponse($like,'Post liked successfully',200);
    }
}
