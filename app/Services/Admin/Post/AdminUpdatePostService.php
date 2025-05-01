<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminUpdatedPostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AdminUpdatePostService implements AdminUpdatedPostInterface
{


    /**
     * Updates the published status of a specific post.
     *
     * This function attempts to find a post by its ID and update its published status
     * using the data provided in the request. If the post is found and updated successfully,
     * it commits the transaction and returns the updated post data along with a success message.
     * If the post is not found, it returns a "Post Not Found" message. In case of any errors during
     * the update process, it rolls back the transaction and returns the error message.
     *
     * @param int $id The ID of the post to update.
     * @param \App\Http\Requests\User\PostRequest $request The request containing the data to update the post.
     * @return array An associative array containing the message and data of the operation.
     */


    public function changePublished($id,$request)
    {
        try {
            DB::beginTransaction();
            $post=Post::find($id);
            if(!$post){
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
                'is_published' => $post->is_published===null?'-':$post->is_published,
                'publish_date' => $post->publish_date===null?'-':$post->publish_date,
                'meta_description' => $post->meta_description===null?'-':$post->meta_description,
                'keywords'=>$post->keywords,
                'tags' => $post->tags===null?'-':$post->tags,
            ];
            $message = 'Post updated successfully';
            DB::commit();
            return ['data'=>$data,'message'=>$message];

        }catch (\Exception $e){
            DB::rollBack();
            return [
                'message' => 'There are an errors',
                'data' => $e->getMessage(),
            ];
        }
    }
}
