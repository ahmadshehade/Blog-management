<?php

namespace App\Services\Admin\Comments;

use App\Interfaces\Admin\Comments\AdminCreateCommentInterface;
use App\Models\Comment;
use App\Models\Post;
use Exception;

use Illuminate\Support\Facades\DB as FacadesDB;



class AdminCreateCommentService implements AdminCreateCommentInterface{



    /**
     * Summary of createComment
     * @param \App\Http\Requests\User\CommentRequest $request
     * @throws \Exception
     * @return array{code: int, data: array{comment_id: mixed, content: mixed, email: string, name: string, parent: mixed, title: mixed, message: string}|array{code: int, message: string, status: string}}
     */
    public function createComment($request){
      try{
        FacadesDB::beginTransaction();
        $validData=$request->validated();
        $post=Post::where('id',$validData['post_id'])
        ->where('status','published')->first();
        if(!$post){
            throw new Exception('Post Not Found or Not Published');
        }
         $comment=Comment::create($validData);
         $comment->forceFill(['admin_id'=>auth('admin')->user()->id])->save();
         $data=[
            "name"=>auth('admin')->user()->name,
            "email"=>auth('admin')->user()->email,
            "comment_id"=>$comment->id,
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
