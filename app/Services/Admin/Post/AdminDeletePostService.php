<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminDeletedPostInterface;
use App\Models\Post;

class AdminDeletePostService implements AdminDeletedPostInterface
{



    /**
     * Summary of deletePost
     * @param mixed $id
     * @return array{code: int, data: array{URL: mixed, body: mixed, category: mixed, editor_notes: mixed, email: mixed, id: mixed, is_featured: mixed, is_published: mixed, is_scheduled: mixed, keywords: mixed, meta_description: mixed, publish_date: mixed, slug: mixed, status: mixed, tags: mixed, title: mixed, user: mixed, message: string}|array{data: null, message: string}}
     */
    public function deletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return [
                'message' => 'Post Not Found',
                'data' => null,
            ];
        }
        $post->delete();
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

        $message = 'Post Deleted successfully';
        return [
        'data' => $data,
        'message' => $message,
        'code'=>200,
    ];
    }


}
