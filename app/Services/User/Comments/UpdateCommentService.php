<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\UpdateCommentInterface;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class UpdateCommentService implements UpdateCommentInterface{


    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\User\CommentRequest $request
     * @throws \Exception
     * @return array{code: int, data: array{content: mixed, email: string, id: mixed, name: string, parent: mixed, title: mixed, message: string}|array{code: int, data: null, message: string}|array{data: null, message: string}}
     */
    public function update($id, $request)
    {
        try{

           DB::beginTransaction();
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
            if($comment->post_id!=$dataUpadted["post_id"]){
              throw new \Exception("Error! post_id is not match");
            }
            $comment->update($dataUpadted);
            $data=[
                "name"=>auth('api')->user()->name,
                "email"=>auth('api')->user()->email,
                 "title" => $comment->post
                ? $comment->post->title
                : ($comment->parent && $comment->parent->post ?
                 $comment->parent->post->title : null),
                "content"=>$comment->body,
                'id' => $comment->id,
                "parent"=>$comment->parent? $comment->parent->body:"*",
               ];
               DB::commit();
            return [
                "message"=>"success",
                "data"=>$data,
                "code"=> 200,

            ];
        }catch(\Exception $e){
            DB::rollBack();
            return [
                "message"=>$e->getMessage(),
                "data"=>null,
                "code"=> 500
            ];
        }
    }
}
