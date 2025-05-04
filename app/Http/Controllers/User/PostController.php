<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PostRequest;
use App\Interfaces\User\Post\PostCreateInterface;
use App\Interfaces\User\Post\PostDeleteInterface;
use App\Interfaces\User\Post\PostListenInterface;
use App\Interfaces\User\Post\PostUpdateInterface;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postListen;
    protected $postCreate;
    protected $postUpdate;
    protected $postDelete;


    /**
     * Initialize the PostController with the necessary interface implementations for post operations.
     *
     * @param PostListenInterface $postListen  Interface for listening to post-related data.
     * @param PostCreateInterface $postCreate  Interface for creating new posts.
     * @param PostUpdateInterface $postUpdate  Interface for updating existing posts.
     * @param PostDeleteInterface $postDelete  Interface for deleting posts.
     */


    public function __construct(
        PostListenInterface $postListen,
        PostCreateInterface $postCreate,
        PostUpdateInterface $postUpdate,
        PostDeleteInterface $postDelete
    )
    {
        $this->postListen = $postListen;
        $this->postCreate = $postCreate;
        $this->postUpdate = $postUpdate;
        $this->postDelete = $postDelete;
    }



    /**
     * Retrieves all posts.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */

    public function index()
    {
        $posts = $this->postListen->getAllPosts();
        return $this->successMessage($posts['message'], $posts['data'], $posts['code']);
    }


    /**
     * Stores a newly created post in storage.
     *
     * @param  \App\Http\Requests\User\PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(PostRequest $request)
    {
        $post = $this->postCreate->storePost($request);
        return $this->successMessage($post['message'], $post['data'], $post['code']);
    }


    /**
     * Retrieves posts and returns a success message with the posts data.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function show()
    {
        $posts = $this->postListen->getPosts();
        return $this->successMessage($posts['message'], $posts['data'], $posts['code']);
    }


    /**
     * Updates the specified post in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\User\PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function update($id, PostRequest $request)
    {
        $post = $this->postUpdate->updatePost($id, $request);
        return $this->successMessage($post['message'], $post['data'], $post['code']);
    }


    /**
     * Removes the specified post from storage.
     *
     * @param  int  $id  The ID of the post to be deleted.
     * @return \Illuminate\Http\JsonResponse  A success message indicating the post has been deleted.
     */


    public function destroy($id)
    {
        $deleted = $this->postDelete->deletePost($id);
        return $this->successMessage($deleted['message'], $deleted['data'], $deleted['code']);
    }

    /**
     * Retrieves a specific post by its ID.
     *
     * @param  int  $id  The ID of the post to be retrieved.
     * @return \Illuminate\Http\JsonResponse  A success message with the post data.
     */


    public function getPost($id)
    {
        $post = $this->postListen->getPost($id);
        return $this->successMessage($post['message'], $post['data'], $post['code']);
    }
}
