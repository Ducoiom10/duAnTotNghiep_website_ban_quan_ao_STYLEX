<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('client.posts.index', compact('posts'));
    }

    /**
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('author')
            ->firstOrFail();
        $recentPosts = Post::with('author')
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('client.posts.detail', compact('post', 'recentPosts'));
    }
}
