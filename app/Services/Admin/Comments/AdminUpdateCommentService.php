<?php

namespace App\Services\Admin\Comments;

use App\Interfaces\Admin\Comments\AdminUpdateCommentInterface;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class AdminUpdateCommentService implements AdminUpdateCommentInterface{


    /**
     * Summary of updateComment
     * @param mixed $id
     * @param mixed $request
     * @throws \Exception
     * @return array{code: int, data: array{comment_id: mixed, content: mixed, email: mixed, name: mixed, parent: mixed, title: mixed, message: string}|array{code: int, data: string, message: string}|array{data: bool, message: string}}
     */
    public function updateComment($id, $request)
    {


        try{
            DB::beginTransaction();
            $dataUpadted=$request->validated();
            $comment=Comment::find($id);
            if(!$comment){
                return [
                    'message'=>'Comment not found',
                    'data'=>false
                ];
            }
            if($comment->admin_id !=auth('admin')->user()->id){
                throw new \Exception('You are not allowed to update this comment');
            }
            if($comment->post_id!=$dataUpadted["post_id"]){
                throw new \Exception("Error! post_id is not match");
              }
            $comment->update($dataUpadted);
            $data=[
                "name"=>$comment->user?$comment->user->name:$comment->admin->name,
                "email"=>$comment->user?$comment->user->email:$comment->admin->email,
                 "title" => $comment->post
                ? $comment->post->title
                : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
                "comment_id"=>$comment->id,
                "content"=>$comment->body,
                "parent"=>$comment->parent? $comment->parent->body:"*",
               ];
            DB::commit();
            return [
                'message'=>'Comment updated successfully',
                'data'=>$data,
                'code'=>200,
            ];
        }catch(\Exception $e){
            DB::rollback();
            return [
                'message'=>'Error updating comment',
                'data'=>$e->getMessage(),
                'code'=> 500
            ];
        }
    }


}
