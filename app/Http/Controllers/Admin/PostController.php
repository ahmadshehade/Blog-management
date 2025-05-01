<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PostRequest;
use App\Interfaces\Admin\Post\AdminCreatePostInterface;
use App\Interfaces\Admin\Post\AdminDeletedPostInterface;
use App\Interfaces\Admin\Post\AdminListenPostsInterface;
use App\Interfaces\Admin\Post\AdminUpdatedPostInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postListen;
    protected $postCreate;
    protected $postUpdate;
    protected $postDelete;


/**
 * PostController constructor.
 *
 * @param AdminListenPostsInterface $adminListenPosts Service for listening to posts.
 * @param AdminCreatePostInterface  $adminCreatePost  Service for creating posts.
 * @param AdminUpdatedPostInterface $adminUpdatedPost Service for updating posts.
 * @param AdminDeletedPostInterface $adminDeletedPost Service for deleting posts.
 */


    public function __construct(
        AdminListenPostsInterface $adminListenPosts,
        AdminCreatePostInterface  $adminCreatePost,
        AdminUpdatedPostInterface $adminUpdatedPost,
        AdminDeletedPostInterface $adminDeletedPost,
    )
    {
        $this->postListen = $adminListenPosts;
        $this->postCreate = $adminCreatePost;
        $this->postUpdate = $adminUpdatedPost;
        $this->postDelete = $adminDeletedPost;
    }




    /**
     * Display a listing of all posts.
     *
     * This method uses the PostListen service to retrieve all posts
     * and returns a success message with the posts data.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function index()
    {
        $posts = $this->postListen->getAllPosts();
        return $this->successMessage($posts['message'], $posts['data'], 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * This method uses the AdminCreatePost service to create a new post
     * and returns a success message with the post data.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(PostRequest $request)
    {
        $post = $this->postCreate->makePost($request);
        return $this->successMessage($post['message'], $post['data'], 201);
    }


    /**
     * Display the specified post.
     *
     * This method retrieves a post by its ID using the PostListen service
     * and returns a success message with the post data.
     *
     * @param int $id The ID of the post to display.
     * @return \Illuminate\Http\JsonResponse
     */


    public function show($id)
    {
        $post = $this->postListen->getPost($id);
        return $this->successMessage($post['message'], $post['data'], 200);
    }


    /**
     * Update the specified post.
     *
     * This method uses the AdminUpdatePost service to change the published status of a post
     * and returns a success message with the post data.
     *
     * @param int $id The ID of the post to update.
     * @param PostRequest $request The request containing the post data.
     * @return \Illuminate\Http\JsonResponse
     */

    public function update($id, PostRequest $request)
    {
        $post = $this->postUpdate->changePublished($id, $request);
        return $this->successMessage($post['message'], $post['data'], 200);
    }


    /**
     * Display a listing of the posts belonging to the currently authenticated user.
     *
     * This method uses the PostListen service to retrieve all posts belonging to the user
     * and returns a success message with the post data.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getMyPosts()
    {
        $posts = $this->postListen->getMyPosts();
        return $this->successMessage($posts['message'], $posts['data'], 200);
    }


    /**
     * Delete a post.
     *
     * This method uses the AdminDeletePost service to delete a post
     * and returns a success message with the post data.
     *
     * @param int $id The ID of the post to delete.
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy($id)
    {
        $post = $this->postDelete->deletePost($id);
        return $this->successMessage($post['message'], $post['data'], 200);
    }
}
