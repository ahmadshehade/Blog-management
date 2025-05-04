<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\UpdateCommentInterface;
use App\Models\Comment;
use App\Models\Post;


class UpdateCommentService implements UpdateCommentInterface{


       /**
     * Update an existing comment.
     *
     * @param  int  $id The ID of the comment to update.
     * @param \App\Http\Requests\User\CommentRequest Request  $request The request object containing the validated data for the update.
     * @return array An array containing a message and data about the updated comment, or an error message.
     *               Returns ['message' => 'success', 'data' => [...]] on successful update.
     *               Returns ['message' => 'Comment not found', 'data' => null] if the comment does not exist.
     *               Returns ['message' => 'Comment not unauthorized', 'data' => null] if the authenticated user is not the comment owner.
     * @throws \Exception If an unexpected error occurs during the update process.
     */
    public function update($id, $request)
    {
        try{


           $comment=Comment::find($id);

            if (!$comment ) {
                return [
                    "message" => "Comment not found ",
                    "data" => null,
                ];
            }
            if( $comment->user_id !== auth('api')->id()){

                return [
                    "message" => "Comment not  unauthorized",
                    "data" => null,
                ];
            }
            $dataUpadted=$request->validated();
            if( $comment->parent_id!=null){
                   $comment->update($dataUpadted);
                   unset($dataUpadted['parent_id']);
            }else{
                $comment->update($dataUpadted);
            }
            $data=[
                "name"=>auth('api')->user()->name,
                "email"=>auth('api')->user()->email,
                 "title" => $comment->post
                ? $comment->post->title
                : ($comment->parent && $comment->parent->post ?
                 $comment->parent->post->title : null),
                "content"=>$comment->body,
                "parent"=>$comment->parent? $comment->parent->body:"*",
               ];
            return [
                "message"=>"success",
                "data"=>$data,
                'code'=> 200,
            ];
        }catch(\Exception $e){
            return [
                "message"=>$e->getMessage(),
                "data"=>null,
                "code"=> 500
            ];
        }
    }
}
