<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\CreateCommentInterface;
use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB as FacadesDB;

class CreateCommentService implements CreateCommentInterface{


    /**
     * Summary of store
     * @param \App\Http\Requests\User\CommentRequest $request
     * @throws \Exception
     * @return array{code: int, data: array{content: mixed, email: string, id: mixed, name: string, parent: mixed, title: mixed, message: string}|array{code: int, data: null, error: string, message: string}}
     */
    public function store($request){

        try{
            FacadesDB::beginTransaction();
            $validData = $request->validated();
            $post=Post::where('id',$validData['post_id'])
            ->where('status','published')->first();
            if(!$post){
                throw new Exception('Post Not Found or Not Published');
            }
            $comment = Comment::create(attributes: $validData);
            $comment->forceFill(['user_id'=>auth('api')->user()->id])->save();
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
                'code'=> 500,
                'data' => null,
            ];
        }
    }

}
