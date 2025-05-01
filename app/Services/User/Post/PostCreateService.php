<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostCreateInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostCreateService implements PostCreateInterface
{

    public function storePost($request)
    {
        try {
            DB::beginTransaction();
            $post = Post::create($request->validated());

            $post->forceFill(['user_id'=> auth('api')->user()->id])->save();
            DB::commit();
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
            $message = 'Post created successfully';
            return ['data'=>$data,'message'=>$message];


        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'message'=>'There are an errors',
                'data'=>$e->getMessage(),
            ];
        }
    }
}
