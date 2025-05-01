<?php

namespace App\Services\Admin\Post;

use App\Interfaces\Admin\Post\AdminUpdatedPostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AdminUpdatePostService implements AdminUpdatedPostInterface
{

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
                'is_published' => $post->is_published==1?0:1,
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
