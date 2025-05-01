<?php

namespace App\Services\User\Post;

use App\Interfaces\User\Post\PostUpdateInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class PostUpdateService implements PostUpdateInterface
{


/**
 * Updates a post with the given ID using the provided request data.
 *
 * Initiates a database transaction to update the post. If the post with the
 * specified ID does not exist, it returns a "post not Found" message. After
 * updating, it retrieves the updated post information and returns it along with
 * a success message. If an exception occurs during the update process, it
 * rolls back the transaction and returns the error message.
 *
 * @param int $id The ID of the post to be updated.
 * @param \App\Http\Requests\User\PostRequest $request The request containing validated data
 * for updating the post.
 * @return array An array containing the updated post data and a message, or an
 * error message if the update fails.
 */


    public function updatePost($id, $request)
    {
        try {
            DB::beginTransaction();
            $post = Post::find($id);
            if (!$post) {
                return ["data"=>"error","message"=> "post not Found"];
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
