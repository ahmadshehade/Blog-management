<?php

namespace App\Services\Admin\Comments;

use App\Interfaces\Admin\Comments\AdminDeleteCommentInterface;
use App\Models\Comment;

class AdminDeleteCommentService implements AdminDeleteCommentInterface
{

    /**
     * Summary of destroy
     * @param int $id
     * @return array{data: array{content: mixed, email: mixed, name: mixed, parent: mixed, title: mixed, message: string,code:int}|array{data: bool, message: string, code:int}}
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return [
                'message' => "Comment Not Found",
                'data' => false,

            ];
        }
        $comment->delete();

        $data = [
            "name" => $comment->user ? $comment->user->name : $comment->admin->name,
            "email" => $comment->user ? $comment->user->email : $comment->admin->email,
            "title" => $comment->post
                ? $comment->post->title
                : ($comment->parent && $comment->parent->post ? $comment->parent->post->title : null),
            "content" => $comment->body,
            "parent" => $comment->parent ? $comment->parent->body : "*",
        ];
        return [
            'message' => 'Successfully Delete Comment',
            'data' => $data,
            'code'=>200,
        ];
    }
}
