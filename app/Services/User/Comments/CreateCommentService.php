<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\CreateCommentInterface;
use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\DB as FacadesDB;

class CreateCommentService implements CreateCommentInterface{



/**
 * Store a newly created comment in storage.
 *
 * @param  \App\Requests\User\CommentRequest  $request
 * @return array
 */
    public function store($request){

        try{
            FacadesDB::beginTransaction();
            $validData = $request->validated();
            $comment = Comment::create(attributes: $validData);
            $comment->forceFill(['user_id'=>auth('api')->user()->id])->save();
           $data=[
            "name"=>auth('api')->user()->name,
            "email"=>auth('api')->user()->email,
             "title" => $comment->post
            ? $comment->post->title
            : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
                    "content"=>$comment->body,
            "parent"=>$comment->parent? $comment->parent->body:"*",
           ];
           FacadesDB::commit();
           return[
            'message'=>'Comment Create Successfully',
            'data'=>$data,
            'code'=>201
           ];
        }catch(Exception $e){
            FacadesDB::rollBack();
            return [
                'message'=>'error',
                'error'=>$e->getMessage(),
                'code'=> 500
            ];
        }
    }
}
