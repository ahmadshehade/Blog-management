<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminListenPostsInterface;
use App\Models\Post;

class AdminListenPostsService implements AdminListenPostsInterface
{

    public function getAllPosts()
    {
        $posts=Post::all();
        $data=[
            'user' => auth('api')->check()?auth('api')->user()->name:auth('admin')->user()->name,
            'email' => auth('api')->check()?auth('api')->user()->email:auth('admin')->user()->email,
        ];
        foreach ($posts as $post){
            $data[] = [
                'user'=>$post->user?$post->user->name:$post->admin->name,
                'email'=>$post->user?$post->user->email:$post->admin->email,
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
        }
        $message = 'Post Get All successfully';
        return [
            'data'=>$data,
            'message'=>$message
        ];
    }

    public function getMyPosts()
    {
       $posts=Post::where('admin_id',auth('admin')->user()->id)->get();
        $data=[
            'user' => auth('admin')->user()->name,
            'email' => auth('admin')->user()->email,
        ];
        foreach ($posts as $post){
            $data[] = [

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
        }
        $message="Get My Post Successfully";

        return [
            'data'=>$data,
            'message'=>$message,
        ];
    }

    public function getPost($id)
    {
        $post=Post::find($id);
        if(!$post){
            return[
                'message'=>'Post Not Found',
                'data'=>null,
            ];
        }
        $data = [
            'user'=>$post->user?$post->user->name:$post->admin->name,
            'email'=>$post->user?$post->user->email:$post->admin->email,
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
        $message='Post Find !';

        return [
            'message'=>$message,
            'data'=>$data,
        ];
    }

}
