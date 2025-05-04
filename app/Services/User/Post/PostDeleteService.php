<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostDeleteInterface;
use App\Models\Post;

class PostDeleteService implements PostDeleteInterface
{


    /**
     * Deletes a post by its ID and returns details of the deleted post.
     *
     * @param int $id The ID of the post to be deleted.
     * @return array An array containing the details of the deleted post and a success message.
     */


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
        return ['data' => $data, 'message' => $message,'code'=>200];
    }
}
