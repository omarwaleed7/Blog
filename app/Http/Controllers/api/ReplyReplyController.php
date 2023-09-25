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
        $reply_reply=ReplyReply::where('reply_id',$reply_id);
        if($reply_reply){
            return $this->apiResponse($reply_reply,'Reply replies retrieved successfully');
        }
        else{
            return $this->apiResponse($reply_reply,'Reply replies not found');
        }
    }

    // update a reply's reply
    public function update(ReplyReplyRequest $request,$id){
        $reply_reply=ReplyReply::find($id);
        if($reply_reply){
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
            $reply_reply->delete();
            return $this->apiResponse(null,'Reply reply deleted successfully',204);
        }
        else{
            return $this->apiResponse(null,'Reply reply not found',404);
        }
    }

    // like a reply's reply
    public function like(ReplyReplyRequest $request){
        $like=ReplyReplyLike::create([
            'user_id'=>Auth()->User()->id,
            'reply_reply_id'=>$request->reply_reply_id
        ]);
        return $this->apiResponse($like,'Comment liked successfully',200);
    }
}
