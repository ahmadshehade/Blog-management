<?php

namespace App\Http\Middleware\User;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostOperationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $post_id = $request->route('id');
        $post = Post::where('id', $post_id)->first();
        if ($post->user->id == auth('api')->user()->id) {
            return $next($request);
        }
        return \response()->json([
            'error' => 'Unauthorized',
        ], 403);
    }
}
