<?php

namespace App\Interfaces\Admin\Post;

interface AdminListenPostsInterface
{

    public function getAllPosts();


    public function getMyPosts();


    public function getPost($id);
}
