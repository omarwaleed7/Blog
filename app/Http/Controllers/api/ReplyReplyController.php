<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyReplyRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\ReplyReply;
use App\Models\ReplyReplyLike;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
class ReplyReplyController extends Controller
{
    // trait for api response
    use ApiResponseTrait;

    // store a reply's reply
    public function store(ReplyReplyRequest $request){
        $reply_reply=ReplyReply::create([
            'body'=>$request->body,
            'photo'=>$request->photo,
            'user_id'=>Auth()->User()->id,
            'reply_id'=>$request->reply_id
        ]);
        return $this->apiResponse($reply_reply,'Reply reply created successfully');
    }

    // show reply replies
    public function index($reply_id){
        $reply_replies=ReplyReply::where('reply_id',$reply_id)->get();

        //check if reply replies
        if($reply_replies){
            return $this->apiResponse($reply_replies,'Reply replies retrieved successfully');
        }
        else{
            return $this->apiResponse($reply_replies,'Reply replies not found');
        }
    }

    // update a reply's reply
    public function update(ReplyReplyRequest $request,$id){
        $reply_reply=ReplyReply::find($id);

        // check if reply
        if($reply_reply){
            // check if user is reply owner
            if(Auth()->User()->id!==$reply_reply->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $reply_reply->update([
                'body'=>$request->body,
                'photo'=>$request->photo
            ]);
            $updated_reply_reply=ReplyReply::find($id);
            return $this->apiResponse($updated_reply_reply,'Reply reply updated successfully',200);
        }
        else{
            return $this->apiResponse(null,'Reply reply not found',404);
        }
    }

    // delete a reply's reply
    public function delete($id){
        $reply_reply=ReplyReply::find($id);
        if($reply_reply){
            // check if user isn't reply reply owner
            if(Auth()->User()->id!==$reply_reply->user_id){
                return $this->apiResponse(null,'Unauthorized',403);
            }
            $reply_reply->delete();
            return $this->apiResponse(null,'Reply reply deleted successfully',204);
        }
        else{
            return $this->apiResponse(null,'Reply reply not found',404);
        }
    }

    // like a reply's reply
    public function like(ReplyReplyRequest $request){

        // check if user already liked post
        $existing_like = ReplyReplyLike::where('user_id', Auth()->User()->id)
            ->where('reply_reply_id', $request->reply_reply_id)
            ->first();

        // if like exists
        if($existing_like){
            $existing_like->delete();
            return $this->apiResponse(null,'Reply unliked successfully',200);
        }
        $like=ReplyReplyLike::create([
            'user_id'=>Auth()->User()->id,
            'reply_reply_id'=>$request->reply_reply_id
        ]);
        return $this->apiResponse($like,'Comment liked successfully',200);
    }
}
