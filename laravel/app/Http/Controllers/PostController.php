<?php

namespace App\Http\Controllers;

use App\Enums\EstadoPost;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->where('estado', EstadoPost::Publicado)
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_unless($post->estado === EstadoPost::Publicado, 404);

        $post->load('autor');

        return view('posts.show', compact('post'));
    }
}
