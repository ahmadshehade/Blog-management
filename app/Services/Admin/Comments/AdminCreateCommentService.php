<?php

namespace App\Services\Admin\Comments;

use App\Interfaces\Admin\Comments\AdminCreateCommentInterface;
use App\Models\Comment;
use Exception;

use Illuminate\Support\Facades\DB as FacadesDB;



class AdminCreateCommentService implements AdminCreateCommentInterface{

    /**
     * Summary of createComment
     * @param \App\Http\Requests\User\CommentRequest $request
     * @return array{data: array{content: mixed, email: string, name: string, parent: mixed, title: mixed, message: string,code:int}|array{message: string, status: string,code:int}}
     */

    public function createComment($request){
      try{
        FacadesDB::beginTransaction();
         $comment=Comment::create($request->validated());
         $comment->forceFill(['admin_id'=>auth('admin')->user()->id])->save();
         $data=[
            "name"=>auth('admin')->user()->name,
            "email"=>auth('admin')->user()->email,
             "title" => $comment->post
            ? $comment->post->title
            : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
                    "content"=>$comment->body,
            "parent"=>$comment->parent? $comment->parent->body:"*",
           ];
         FacadesDB::commit();
         return [
            'message'=>'Successfully created comment',
            'data'=>$data,
            'code'=>201,
         ];
        }catch(Exception $e){

            FacadesDB::rollBack();
            return[
                "status"=>"failed",
                "message"=>$e->getMessage(),
                'code'=>500,
            ];
        }

    }
}
