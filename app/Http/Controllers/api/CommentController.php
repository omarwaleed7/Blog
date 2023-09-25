<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // trait for api response
    use ApiResponseTrait;

    // store a comment for a post
    public function store(CommentRequest $request){
        $comment=Comment::create([
            'body'=>$request->body,
            'user_id'=>Auth()->User()->id,
            'post_id'=>$request->post_id
        ]);
        return $this->apiResponse($comment,'Comment created successfully',200);
    }

    // show comments for a post
    public function index($post_id){
        $comments=Comment::find($post_id);

        //check if comments
        if($comments){
            return $this->apiResponse($comments,'Comments retrieved successfully',200);
        }
        else{
            return $this->apiResponse(null,'Comments not found',404);
        }
    }

    // update a comment
    public function update(CommentRequest $request,$id){

        // check if comment
        $comment = Comment::find($id);
        if ($comment) {
            // check if user isn't comment owner
            if (Auth()->User()->id !== $comment->user_id) {
                return $this->apiResponse(null, 'Unauthorized', 403);
            }
            $comment->update([
                'body' => $request->body,
            ]);
            $comment = Comment::find($id);
            return $this->apiResponse($comment, 'Comment updated successfully', 200);
        }
        else{
            return $this->apiResponse(null,'Comment not found',404);
        }
    }

    // delete a comment
    public function delete($id){
        $comment=Comment::find($id);

        // check if post
        if($comment){

            // check if user isn't comment owner
            if(Auth()->User()->id!==$comment->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $comment->delete();
            return $this->apiResponse(null,'Comment deleted successfully',204);
        }
        else{
            return $this->apiResponse(null,'Comment not found',404);
        }
    }

    // store a like
    public function like(Request $request){

        // check if user already liked post
        $existing_like = CommentLike::where('user_id', Auth()->User()->id)
            ->where('comment_id', $request->comment_id)
            ->first();

        // if like exists
        if($existing_like){
            $existing_like->delete();
            return $this->apiResponse(null,'Comment unliked successfully',200);
        }
        $like=CommentLike::create([
            'user_id'=>Auth()->User()->id,
            'comment_id'=>$request->comment_id
        ]);
        return $this->apiResponse($like,'Comment liked successfully',200);
    }
}
