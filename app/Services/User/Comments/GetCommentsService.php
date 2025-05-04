<?php

namespace App\Services\User\Comments;

use App\Interfaces\User\Comments\GetCommentsInterface;
use App\Models\Post;
use App\Traits\GetReplayTrait;

class GetCommentsService implements GetCommentsInterface
{

    use GetReplayTrait;

    /**
     * Retrieve comments for a specific post, including replies.
     *
     * @param int $id The ID of the post.
     * @return array An array containing a message and the post's comments data, or a not found message.
     *               Returns ['message' => 'Post comments fetched successfully', 'data' => ['post' => ..., 'comments' => [...]]] on success.
     *               Returns ['message' => 'Post not found', 'data' => null] if the post does not exist.
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
        $comments = $post->comments;
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
