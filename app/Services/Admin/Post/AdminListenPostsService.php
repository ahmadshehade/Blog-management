<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminListenPostsInterface;
use App\Models\Post;

class AdminListenPostsService implements AdminListenPostsInterface
{


  


    /**
     * Get all posts
     *
     * @return array
     */
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
            'is_published' => $post->is_published === null ? '-' : $post->is_published, 
            'publish_date' => $post->publish_date === null ? '-' : $post->publish_date, 
            'meta_description' => $post->meta_description === null ? '-' : $post->meta_description,  
            'keywords' => $post->keywords, 
            'tags' => $post->tags === null ? '-' : $post->tags, 
            'status' => $post->status,
            'category' => $post->category ? $post->category->name : '-', 
            'is_featured' => $post->is_featured === null ? '-' : $post->is_featured,    
            'is_scheduled' => $post->is_scheduled === null ? '-' : $post->is_scheduled, 
            'editor_notes' => $post->editor_notes === null ? '-' : $post->editor_notes, 
             'URL'=>$post->canonical_url===null?'-':$post->canonical_url,
            ];
        }
        $message = 'Post Get All successfully';
        return [
            'data'=>$data,
            'message'=>$message
        ];
    }


    /**
     * @return array
     */
    /*
     * Get My Posts
     *
     * This function is used to get all my posts
     *
     * @return array data and message
     */

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
                'is_published' => $post->is_published === null ? '-' : $post->is_published, 
                'publish_date' => $post->publish_date === null ? '-' : $post->publish_date, 
                'meta_description' => $post->meta_description === null ? '-' : $post->meta_description,  
                'keywords' => $post->keywords, 
                'tags' => $post->tags === null ? '-' : $post->tags, 
                'status' => $post->status,
                'category' => $post->category ? $post->category->name : '-', 
                'is_featured' => $post->is_featured === null ? '-' : $post->is_featured,    
                'is_scheduled' => $post->is_scheduled === null ? '-' : $post->is_scheduled, 
                'editor_notes' => $post->editor_notes === null ? '-' : $post->editor_notes, 
                 'URL'=>$post->canonical_url===null?'-':$post->canonical_url,
            ];
        }
        $message="Get My Post Successfully";

        return [
            'data'=>$data,
            'message'=>$message,
        ];
    }


   







    /**
     * Get a post by ID
     *
     * This function is used to get a post by ID
     *
     * @param int $id post ID
     *
     * @return array data and message
     */

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
            'is_published' => $post->is_published === null ? '-' : $post->is_published, 
            'publish_date' => $post->publish_date === null ? '-' : $post->publish_date, 
            'meta_description' => $post->meta_description === null ? '-' : $post->meta_description,  
            'keywords' => $post->keywords, 
            'tags' => $post->tags === null ? '-' : $post->tags, 
            'status' => $post->status,
            'category' => $post->category ? $post->category->name : '-', 
            'is_featured' => $post->is_featured === null ? '-' : $post->is_featured,    
            'is_scheduled' => $post->is_scheduled === null ? '-' : $post->is_scheduled, 
            'editor_notes' => $post->editor_notes === null ? '-' : $post->editor_notes, 
             'URL'=>$post->canonical_url===null?'-':$post->canonical_url,
        ];
        $message='Post Find !';

        return [
            'message'=>$message,
            'data'=>$data,
        ];
    }

}