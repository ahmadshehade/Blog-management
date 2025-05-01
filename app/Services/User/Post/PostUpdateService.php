<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostUpdateInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class PostUpdateService implements PostUpdateInterface
{

    public function updatePost($id, $request)
    {
        try {
            DB::beginTransaction();
            $post = Post::find($id);
            if (!$post) {
                return "post not Found";
            }
            $post = $post->update($request->validated());
            $post = Post::find($id);
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
            $message = 'Post updated successfully';
            DB::commit();
            return ['data'=>$data,'message'=>$message];

        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message'=>'There are an errors',
                'data'=>$e->getMessage(),
            ];

        }
    }
}
