<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;

trait ApiResponseTrait
{
    public function ApiResponseTrait($data=null,$message=null,$status=null)
    {
        $array=[
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];
        return response($array,$status);
    }
    public function ApiValidation($request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        return($validator);
    }
}
