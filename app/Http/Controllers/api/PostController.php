<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostView;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;

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
            'photo'=>$request->photo
        ]);
        return $this->apiResponse($post,'Post stored successfully',201);
    }

    // show all posts
    public function index(){
        $posts=Post::all();
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

        if($post){
            // using view method
            $this->view($id);
            return $this->apiResponse($post,'Post retrieved successfully',200);
        }
        else{
            return $this->apiResponse(null,'Post not found',404);
        }
    }

    // update a post
    public function update(PostRequest $request,$id){
        Post::find($id)->update([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>Auth()->User()->id,
            'category_id'=>$request->category_id,
            'photo'=>$request->photo
        ]);
        $updated_post=Post::find($id);
        return $this->apiResponse($updated_post,'Post updated successfully',200);
    }

    // delete a post
    public function delete($id){
        $post=Post::find($id);
        if($post){
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
        $like=PostLike::create([
            'user_id'=>Auth()->User()->id,
            'post_id'=>$request->post_id
        ]);
        return $this->apiResponse($like,'Post liked successfully',200);
    }
}