<?php

namespace App\Traits;

trait ApiResponseTrait
{

    // handles api response

    public function apiResponse($data=null,$message=null,$status=null){
        $array=[
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];
        return response($array,$status);
    }
}
