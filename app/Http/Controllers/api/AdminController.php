<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AdminBlock;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ApiResponseTrait;

    // block a user
    public function block(Request $request){
        // check if admin already blocked user
        $existing_block = AdminBlock::where('admin_id', Auth()->User()->id)
            ->where('following_id', $request->blocked_id)
            ->first();
        // if block exists
        if($existing_block){
            $existing_block->delete();
            return $this->apiResponse(null,'User unblocked successfully',200);
        }
        AdminBlock::create([
            'admin_id'=>Auth()->User()->id,
            'blocked_id'=>$request->blocked_id
        ]);
        return $this->apiResponse(null,'User blocked successfully',204);
    }
}
