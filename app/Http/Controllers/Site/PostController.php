<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::where('language_code', app()->getLocale())
                ->orWhere('language_code', 'en')
                ->get();

    return view('site.post.index', compact('posts'));
}

public function show($slug)
{
    $post = Post::where('slug', $slug)
               ->where('language_code', app()->getLocale())
               ->first()
          ?? Post::where('slug', $slug)
               ->where('language_code', 'en')
               ->firstOrFail();

    return view('site.post.show', compact('post'));
}

}
