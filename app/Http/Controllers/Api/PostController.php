<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(){
       // $posts =PostResource::collection(Posts::get());
        $posts=PostResource::collection(Posts::get());
      return $this->ApiResponseTrait($posts,'ok',200);

   // return response($array);

    }

    public function show($id){
       // $post=new PostResource(Posts::find($id));
       $post=Posts::find($id);
        if($post){

            return $this->ApiResponseTrait(new PostResource($post),'ok',200);
    }
        return $this->ApiResponseTrait(null,'not found',404);

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        if($validator->fails()){
            return $this->ApiResponseTrait(null,$validator->errors(),400);
        }


    $post =Posts::create($request->all());
        if($post){

            return $this->ApiResponseTrait(new PostResource($post),'ok',201);
        }
    return $this->ApiResponseTrait(null,'the post not save',400);
    }
    public function update(Request $request,$id){
        $validator=$this->ApiValidation($request);
        if($validator->fails()){
            return $this->ApiResponseTrait(null,$validator->errors(),400);
        }
        $post=Posts::find($id);
        if(!$post){
            return $this->ApiResponseTrait(null,'not found',404);
        }
        $post->update($request->all());
        if($post){

            return $this->ApiResponseTrait(new PostResource($post),'ok',201);
        }

    }
    public function destroy($id){
        $post=Posts::find($id);
        if(!$post){
            return $this->ApiResponseTrait(null,'not found',404);
        }
        $post->delete($id);
        return $this->ApiResponseTrait(null,'delete success',200);


    }
}
