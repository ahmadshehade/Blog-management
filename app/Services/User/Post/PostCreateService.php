<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostCreateInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostCreateService implements PostCreateInterface
{


    /**
     * Create a new post with the given request data.
     *
     * This function create a new post with the given request data and
     * assign it to the user that make the request.
     *
     * @param \App\Http\Requests\User\PostRequest $request The input data for the post.
     *
     * @return array Return the data of the created post, and a message.
     *
     * @throws \Exception If there are any errors during the process.
     */

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
