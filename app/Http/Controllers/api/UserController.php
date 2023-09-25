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
        $following=Following::create([
            'user_id'=>Auth()->User()->id,
            'following_id'=>$request->following_id
        ]);
    }

    // follower user method
    public function follower(Request $request){
        $follower=Follower::create([
            'user_id'=>Auth()->User()->id,
            'follower_id'=>$request->follower_id
        ]);
    }

    // block a user
    public function block(Request $request){
        UserBlock::create([
            'user_id'=>Auth()->User()->id,
            'blocked_id'=>$request->blocked_id
        ]);
        return $this->apiResponse(null,'User blocked successfully',204);
    }
}
