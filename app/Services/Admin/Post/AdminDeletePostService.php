<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminDeletedPostInterface;
use App\Models\Post;

class AdminDeletePostService implements  AdminDeletedPostInterface
{

    public function deletePost($id)
    {
       $post=Post::find($id);
       if(!$post){
           return[
               'message'=>'Post Not Found',
               'data'=>null,
           ];

       }
       $post->delete();
        $data = [
            'user' => $post->user?$post->user->name:$post->admin->name,
            'email' => $post->user?$post->user->email:$post->admin->email,
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
