<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Interfaces\Admin\Comments\AdminCreateCommentInterface;
use App\Interfaces\Admin\Comments\AdminDeleteCommentInterface;
use App\Interfaces\Admin\Comments\AdminListenCommentInterface;
use App\Interfaces\Admin\Comments\AdminUpdateCommentInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $createComment;
    protected $updateComment;
    protected $listenComment;
    protected $deleteComment;

    public function __construct(
        AdminCreateCommentInterface $createComment,
        AdminUpdateCommentInterface $updateComment,
        AdminListenCommentInterface $listenComment,
        AdminDeleteCommentInterface $deleteComment
    )
    {
        $this->createComment = $createComment;
        $this->updateComment = $updateComment;
        $this->listenComment = $listenComment;
        $this->deleteComment = $deleteComment;
    }

    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->listenComment->getAllComment();
        return $this->successMessage($data['message'], $data['data'], $comment['code']);
    }

    /**
     * Summary of getPostComments
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostComments($id)
    {
        $data = $this->listenComment->getPostComments($id);
        return $this->successMessage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of makeComment
     * @param \App\Http\Requests\User\CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeComment(CommentRequest $request)
    {
        $comment = $this->createComment->createComment($request);
        return $this->successMessage($comment['message'], $comment['data'], $comment['code']);
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param \App\Http\Requests\User\CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateComment($id, CommentRequest $request)
    {
        $comment = $this->updateComment->updateComment($id, $request);
        return $this->successMessage($comment['message'], $comment['data'], $comment['code']);
    }

    /**
     * Summary of destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $comment = $this->deleteComment->destroy($id);
        return $this->successMessage($comment['message'], $comment['data'], $comment['code']);
    }

}
