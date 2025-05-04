<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Interfaces\User\Comments\CreateCommentInterface;
use App\Interfaces\User\Comments\DeleteCommentInterface;
use App\Interfaces\User\Comments\GetCommentsInterface;
use App\Interfaces\User\Comments\UpdateCommentInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $getComments;
    protected $createComment;
    protected $updateComment;
    protected $deleteComment;

          /**
           * Undocumented function
           *
           * @param CreateCommentInterface $createComment
           * @param UpdateCommentInterface $updateComment
           * @param DeleteCommentInterface $deleteComment
           * @param GetCommentsInterface $getComments
           */

    public function __construct(
        CreateCommentInterface $createComment,
        UpdateCommentInterface $updateComment,
        DeleteCommentInterface $deleteComment,
        GetCommentsInterface $getComments
    )
    {
         $this->createComment=$createComment;
         $this->updateComment=$updateComment;
         $this->getComments=$getComments;
         $this->deleteComment=$deleteComment;
    }



    /**
     * Summary of store
     * @param \App\Http\Requests\User\CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentRequest $request){

        $data=$this->createComment->store($request);
        return $this->successMessage($data['message'],$data['data'],$data['code']);
    }



    /**
     * Summary of update
     * @param mixed $id
     * @param \App\Http\Requests\User\CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function update($id,CommentRequest $request){
        $data=$this->updateComment->update($id,$request);
        return $this->successMessage($data['message'],$data['data'],$data['code']);
    }

    /**
     * Summary of destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $data=$this->deleteComment->destroy($id);
        return $this->successMessage($data['message'],$data['data'],$data['code']);
    }

    /**
     * Summary of getPotComment
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPotComment($id){
        $data=$this->getComments->getPostComment($id);
        return $this->successMessage($data['message'],$data['data'],$data['code']);
    }
}
