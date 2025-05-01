<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostDeleteInterface;
use App\Models\Post;

class PostDeleteService implements PostDeleteInterface
{

    public function deletePost($id)
    {
        $post = Post::find($id);
        $post->delete();
        $data = [
            'user' => auth('api')->user()->name,
            'email' => auth('api')->user()->email,
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'body' => $post->body,
            'is_published' => $post->is_published===null?'-':$post->is_published,
            'publish_date' => $post->publish_date===null?'-':$post->publish_date,
            'meta_description' => $post->meta_description===null?'-':$post->meta_description,
            'keywords'=>$post->keywords,
            'tags' => $post->tags===null?'-':$post->tags,
        ];
        $message = 'Post Deleted successfully';
        return ['data'=>$data,'message'=>$message];
    }
}
