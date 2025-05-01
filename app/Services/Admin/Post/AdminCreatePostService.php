<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminCreatePostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AdminCreatePostService implements AdminCreatePostInterface
{

    public function makePost($request)
    {
        try {
            DB::beginTransaction();
            $post = Post::create($request->validated());
            $post->forceFill(['admin_id' => auth('admin')->user()->id])->save();
            $data = [
                'admin' => auth('admin')->user()->name,
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
            ];
            $message = "Successfully Make Post !";
            DB::commit();
            return [
                'data' => $data,
                'message' => $message,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'message' => 'There are an errors',
                'data' => $e->getMessage(),
            ];
        }
    }
}
