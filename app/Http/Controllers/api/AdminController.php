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
        AdminBlock::create([
            'admin_id'=>Auth()->User()->id,
            'blocked_id'=>$request->blocked_id
        ]);
        return $this->apiResponse(null,'User blocked successfully',204);
    }
}
