<?php

namespace App\Interfaces\User\Post;

interface PostListenInterface
{


    public  function  getPosts();

    public function getAllPosts();

    public function  getPost($id);
}
