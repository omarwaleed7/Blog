<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use App\Models\ReplyLike;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
class ReplyController extends Controller
{
    // trait for api response
    use ApiResponseTrait;

    // store a reply
    public function store(ReplyRequest $request){
        $reply=Reply::create([
            'body'=>$request->body,
            'user_id'=>Auth()->User()->id,
            'comment_id'=>$request->comment_id
        ]);
        return $this->apiResponse($reply,'Reply created successfully',200);
    }
    // show replies for a comment
    public function index($comment_id){
        $replies=Reply::where('comment_id',$comment_id)->get();

        //check if replies
        if($replies){
            return $this->apiResponse($replies,'Replies retrieved successfully',200);
        }
        else{
            return $this->apiResponse(null,'Replies not found',404);
        }
    }

    // update a reply
    public function update(ReplyRequest $request,$id){
        $reply=Reply::find($id);

        // check if reply
        if($reply){

            // check if user is reply owner
            if(Auth()->User()->id!==$reply->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $reply->update([
                'body'=>$request->body,
            ]);
        $updated_reply=Reply::find($id);
            return $this->apiResponse($updated_reply,'Reply updated successfully',200);
        }
        else{
            return $this->apiResponse(null,'Reply not found',404);
        }
    }

    // delete a reply
    public function delete($id){
        $reply=Reply::find($id);

        // check if reply
        if($reply){

            // check if user isn't reply owner
            if(Auth()->User()->id!==$reply->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $reply->delete();
            return $this->apiResponse(null,'Reply deleted successfully',204);
        }
        else{
            return $this->apiResponse(null,'Reply not found',404);
        }
    }

    // store a like
    public function like(ReplyRequest $request){

        // check if user already liked post
        $existing_like = ReplyLike::where('user_id', Auth()->User()->id)
            ->where('reply_id', $request->reply_id)
            ->first();

        // if like exists
        if($existing_like){
            $existing_like->delete();
            return $this->apiResponse(null,'Reply unliked successfully',200);
        }
        $like=ReplyLike::create([
            'user_id'=>Auth()->User()->id,
            'reply_id'=>$request->reply_id
        ]);
        return $this->apiResponse($like,'Reply liked successfully',200);
    }
}
