<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\DeleteCommentInterface;
use App\Models\Comment;

class DeleteCommentService implements DeleteCommentInterface{



    /**
     * Summary of destroy
     * @param mixed $id
     * @return array{code: int, data: array{content: mixed, email: string, id: mixed, name: string, parent: mixed, title: mixed, message: string}|array{data: bool, message: string}|array{data: null, message: string}}
     */
    public function destroy($id)
    {
         $comment=Comment::find($id);
         if($comment->user_id != auth('api')->user()->id){
            return [
                'message'=>'You Are Not Authorised To Delete This Comment',
                'data'=>null,
            ];
         }

         if(!$comment){
            return [
                'message'=>'Comment Not Found',
                'data'=>false,
            ];
         }


         $data=[
            "name"=>auth('api')->user()->name,
            "email"=>auth('api')->user()->email,
             "title" => $comment->post
            ? $comment->post->title
            : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
                    "content"=>$comment->body,
                    'id' => $comment->id,
            "parent"=>$comment->parent? $comment->parent->body:"*",
           ];

         $comment->delete();
         return [
            'message'=>'Comment Deleted',
            'data'=>$data,
            'code'=>200
         ];
    }
}
