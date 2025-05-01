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


    public function index()
    {
        $posts = $this->postListen->getAllPosts();
        return $this->successMessage($posts['message'], $posts['data'], 200);
    }


    public function store(PostRequest $request)
    {
        $post = $this->postCreate->makePost($request);
        return $this->successMessage($post['message'], $post['data'], 201);
    }

    public function show($id)
    {
        $post = $this->postListen->getPost($id);
        return $this->successMessage($post['message'], $post['data'], 200);
    }

    public function update($id, PostRequest $request)
    {
        $post = $this->postUpdate->changePublished($id, $request);
        return $this->successMessage($post['message'], $post['data'], 200);
    }

    public function getMyPosts()
    {
        $posts = $this->postListen->getMyPosts();
        return $this->successMessage($posts['message'], $posts['data'], 200);
    }

    public function destroy($id)
    {
        $post = $this->postDelete->deletePost($id);
        return $this->successMessage($post['message'], $post['data'], 200);
    }
}
