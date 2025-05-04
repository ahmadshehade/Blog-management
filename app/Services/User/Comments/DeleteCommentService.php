<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\DeleteCommentInterface;
use App\Models\Comment;

class DeleteCommentService implements DeleteCommentInterface{


      /**
     * Delete a comment by its ID after checking user authorization.
     *
     * @param  int  $id The ID of the comment to delete.
     * @return array An array containing a message and optionally data about the deleted comment.
     *               Returns ['message' => 'Comment Deleted', 'data' => [...]] on success.
     *               Returns ['message' => 'You Are Not Authorised To Delete This Comment', 'data' => null] if the user is not the owner.
     *               Returns ['message' => 'Comment Not Found'] if the comment does not exist.
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
