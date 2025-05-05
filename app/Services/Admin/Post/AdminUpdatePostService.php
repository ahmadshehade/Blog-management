<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminUpdatedPostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AdminUpdatePostService implements AdminUpdatedPostInterface
{



    /**
     * Summary of changePublished
     * @param mixed $id
     * @param mixed $request
     * @return array{code: int, data: array{URL: mixed, body: mixed, category: mixed, editor_notes: mixed, email: string, id: mixed, is_featured: mixed, is_published: mixed, is_scheduled: mixed, keywords: mixed, meta_description: mixed, publish_date: mixed, slug: mixed, status: mixed, tags: mixed, title: mixed, user: string, message: string}|array{code: int, data: string, message: string}|array{data: null, message: string}}
     */
    public function changePublished($id, $request)
    {
        try {
            DB::beginTransaction();
            $post = Post::find($id);
            if (!$post) {
                return [
                    'message' => 'Post Not Found',
                    'data' => null,
                ];
            }
            $post->update($request->validated());
            $post = Post::find($id);
            $data = [
                'user' => auth('admin')->user()->name,
                'email' => auth('admin')->user()->email,
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
            $message = 'Post updated successfully';
            DB::commit();
            return ['data' => $data, 'message' => $message,'code'=>200];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'message' => 'There are an errors',
                'data' => $e->getMessage(),
                'code'=> 500
            ];
        }
    }
}
