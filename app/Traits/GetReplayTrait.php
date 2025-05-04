<?php

namespace App\Traits;

use App\Models\Comment;

trait GetReplayTrait
{
    /**
     * Summary of buildCommentTree
     * @param mixed $comment
     * @return array[]|array{content: mixed, email: mixed, id: mixed, owner: mixed, parent: mixed, responses: array}
     */
    
    public function buildCommentTree($comment){
        $item=[
            'id' => $comment->id,
            'owner' => $comment->user ? $comment->user->name :
                ($comment->admin && $comment->admin->id == auth('admin')->id() ? "me" : $comment->admin->name),
            'email' => $comment->user ? $comment->user->email : ($comment->admin ? $comment->admin->email : null),
            'content' => $comment->body,
            'parent' => $comment->parent ? $comment->parent->body : '*',
            'responses' => [],
        ];
        $replies=Comment::where('parent_id',$comment->id)->get();
        foreach ($replies as $reply){
            $item['responses'][]=$this->buildCommentTree($reply);
        }
        return $item;
    }

}
