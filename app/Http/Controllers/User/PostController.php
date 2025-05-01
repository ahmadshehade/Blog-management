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


    public function index()
    {
        $posts = $this->postListen->getAllPosts();
        return $this->successMessage($posts['message'], $posts['data'], 200);
    }

    public function store(PostRequest $request)
    {
        $post = $this->postCreate->storePost($request);
        return $this->successMessage($post['message'], $post['data'], 201);
    }


    public function show()
    {
        $posts = $this->postListen->getPosts();
        return $this->successMessage($posts['message'], $posts['data'], 200);
    }

    public function update($id, PostRequest $request)
    {
        $post = $this->postUpdate->updatePost($id, $request);
        return $this->successMessage($post['message'], $post['data'], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->postDelete->deletePost($id);
        return $this->successMessage($deleted['message'], $deleted['data'], 200);
    }

    public function getPost($id)
    {
        $post = $this->postListen->getPost($id);
        return $this->successMessage($post['message'], $post['data'], 200);
    }
}
