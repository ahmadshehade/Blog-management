<?php

namespace App\Services\Admin\Comments;

use App\Interfaces\Admin\Comments\AdminListenCommentInterface;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\GetReplayTrait;
use Mockery\Exception;

class AdminListenCommentService implements AdminListenCommentInterface
{
    use GetReplayTrait;

    /**
     * Summary of getAllComment
     * @return array{data: array, message: string|array{data: bool, message: string,code:int}}
     */
    public function getAllComment()
    {
        $comments = Comment::all();

        $data = [];
        if ($comments->count() > 0) {
            foreach ($comments as $comment) {
                $data[] = [
                    'id' => $comment->id,
                    "owner" => $comment->user ? $comment->user->name :
                        ($comment->admin->id == auth('admin')->user()->id ? "me" : $comment->admin->name),
                    "email" => $comment->user ? $comment->user->email : $comment->admin->email,
                    "title" => $comment->post
                        ? $comment->post->title
                        : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
                    "content" => $comment->body,
                    "parent" => $comment->parent ? $comment->parent->body : "*",
                ];
            }
            return [
                'message' => 'Get All Comment',
                'data' => $data,
                'code'=>200,
            ];
        }
        return [
            'message' => 'Comments Not Found',
            'data' => false,
            'code'=>404,

        ];

    }



    /**
     * Summary of getPostComments
     * @param int $id
     * @return array{data: array, message: string|array{data: bool, message: string, code: int}}
     */

    public function getPostComments($id)
    {
       try{
           $post=Post::find($id);
           if(!$post){
               return [
                   'message'=>"PostNot Found",
                   'data'=>false,
               ];
           }
           $comments=$post->comments;

           if($comments->count()>0){
               $data=[];
               foreach ($comments as $comment){

                   $data[] = $this->buildCommentTree($comment);
               }
               return [
                 'message'=>'All Comment To Post : '.$post->name,
                 'data'  =>$data,
                 'code'=> 200,
               ];
           }
           return [
               'message'=>'The post has no comments',
               'data'=>false,
               'code'=> 404,
           ];

       }catch (Exception $e){
           return[
               'message'=>'Exception error',
               'error'=>$e->getMessage(),
               'code'=>500,
           ];
       }
    }
}
