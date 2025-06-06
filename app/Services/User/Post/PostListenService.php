<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostListenInterface;
use App\Models\Post;

class PostListenService implements PostListenInterface
{


    /**
     * Summary of getPosts
     * @return array{code: int, data: array, message: string|array{code: int, data: array{email: string, user: string}, message: string}}
     */
    public function getPosts()
    {
        $posts = Post::where('user_id', auth('api')->user()->id)->get();
        $data = [
            'user' => auth('api')->user()->name,
            'email' => auth('api')->user()->email,
        ];
        foreach ($posts as $post) {
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
                'URL' => $post->canonical_url === null ? '-' : $post->canonical_url,
            ];
        }
        $message = "Get My Post Successfully";

        return [
            'data' => $data,
            'message' => $message,
            'code'=>200
        ];
    }


    /**
     * Summary of getAllPosts
     * @return array{code: int, data: array, message: string|array{code: int, data: array{email: string, user: string}, message: string}}
     */
    public function getAllPosts()
    {
        $posts = Post::all();
        $data = [
            'user' => auth('api')->check() ? auth('api')->user()->name : auth('admin')->user()->name,
            'email' => auth('api')->check() ? auth('api')->user()->email : auth('admin')->user()->email,
        ];
        foreach ($posts as $post) {
            $data[] = [
                'user' => $post->user ? $post->user->name : $post->admin->name,
                'email' => $post->user ? $post->user->email : $post->admin->email,
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
                'URL' => $post->canonical_url === null ? '-' : $post->canonical_url,
            ];
        }
        $message = 'Post Get All successfully';
        return [
            'data' => $data,
            'message' => $message,
            'code'=>200,
        ];
    }



    /**
     * Summary of getPost
     * @param mixed $id
     * @return array{code: int, data: array{URL: mixed, body: mixed, category: mixed, editor_notes: mixed, email: mixed, id: mixed, is_featured: mixed, is_published: mixed, is_scheduled: mixed, keywords: mixed, meta_description: mixed, publish_date: mixed, slug: mixed, status: mixed, tags: mixed, title: mixed, user: mixed, message: string}|array{data: null, message: string}}
     */
    public function getPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return [
                'message' => 'Post Not Found',
                'data' => null,
            ];
        }
        $data = [
            'user' => $post->user ? $post->user->name : $post->admin->name,
            'email' => $post->user ? $post->user->email : $post->admin->email,
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
            'URL' => $post->canonical_url === null ? '-' : $post->canonical_url,
        ];
        $message = 'Post Find !';

        return [
            'message' => $message,
            'data' => $data,
            'code'=>200,
        ];
    }
}
