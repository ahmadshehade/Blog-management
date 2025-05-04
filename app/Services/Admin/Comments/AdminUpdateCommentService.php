<?php

namespace App\Services\Admin\Comments;

use App\Interfaces\Admin\Comments\AdminUpdateCommentInterface;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class AdminUpdateCommentService implements AdminUpdateCommentInterface{

    /**
     * Summary of updateComment
     * @param mixed $id
     * @param \App\Http\Requests\User\CommentRequest $request
     * @return array{data: array{content: mixed, email: mixed, name: mixed, parent: mixed, title: mixed, message: string}|array{data: bool, message: string,code:int}|array{data: string, message: string,code:int}}
     */

    public function updateComment($id, $request)
    {


        try{
            DB::beginTransaction();
            $comment=Comment::find($id);
            if(!$comment){
                return [
                    'message'=>'Comment not found',
                    'data'=>false
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
                "name"=>$comment->user?$comment->user->name:$comment->admin->name,
                "email"=>$comment->user?$comment->user->email:$comment->admin->email,
                 "title" => $comment->post
                ? $comment->post->title
                : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
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
