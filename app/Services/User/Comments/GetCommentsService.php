<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\GetCommentsInterface;
use App\Models\Post;
use App\Traits\GetReplayTrait;

class GetCommentsService implements GetCommentsInterface
{

    use GetReplayTrait;

    /**
     * Summary of getPostComment
     * @param mixed $id
     * @return array{code: int, data: array, message: string|array{data: null, message: string}}
     */
    public function getPostComment($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return [
                'message' => 'Post not found',
                'data' => null
            ];
        }
        $commentsData = [];
        $comments = $post->comments->where('parent_id',null);
        foreach ($comments as $comment) {
            $commentsData[] = $this->buildCommentTree($comment);
        }

        return [
            'message' => 'Post comments fetched successfully',
            'data' => [
                'post' => $post->title,
                'comments' => $commentsData,

            ],
            'code'=>200,
        ];
    }

}
