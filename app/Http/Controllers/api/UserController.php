<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Following;
use App\Models\UserBlock;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
class UserController extends Controller
{
    use ApiResponseTrait;

    // follow a user
    public function follow(){
        $this->following();
        $this->follower();
        return $this->apiResponse(null,'Follow stored successfully',204);
    }

    // following user method
    public function following(Request $request){

        // check if user already followed user
        $existing_following = Following::where('user_id', Auth()->User()->id)
            ->where('following_id', $request->following_id)
            ->first();

        // if following exists
        if($existing_following){
            $existing_following->delete();
            return $this->apiResponse(null,'User unfollowed successfully',200);
        }
        $following=Following::create([
            'user_id'=>Auth()->User()->id,
            'following_id'=>$request->following_id
        ]);
    }

    // follower user method
    public function follower(Request $request){

        // check if user already followed user
        $existing_follower = Follower::where('user_id', Auth()->User()->id)
            ->where('following_id', $request->follower_id)
            ->first();

        // if follower exists
        if($existing_follower){
            $existing_follower->delete();
            return $this->apiResponse(null,'User unfollowed successfully',200);
        }
        $follower=Follower::create([
            'user_id'=>Auth()->User()->id,
            'follower_id'=>$request->follower_id
        ]);
    }

    // block a user
    public function block(Request $request){

        // check if user already blocked user
        $existing_block = UserBlock::where('user_id', Auth()->User()->id)
            ->where('following_id', $request->blocked_id)
            ->first();

        // if block exists
        if($existing_block){
            $existing_block->delete();
            return $this->apiResponse(null,'User unblocked successfully',200);
        }
        UserBlock::create([
            'user_id'=>Auth()->User()->id,
            'blocked_id'=>$request->blocked_id
        ]);
        return $this->apiResponse(null,'User blocked successfully',204);
    }
}
