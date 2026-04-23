<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->with('tags')->get();

        return response()->json($posts);

    }

    public function myPosts(Request $request)
    {
        $user = $request->user();

        $posts = $user->posts()->get();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'is_published' => 'boolean',
        ]);

        $user = $request->user();

        $post = $user->posts()->create([
            'title'        => $request->title,
            'content'      => $request->content,
            'is_published' => $request->is_published ?? false,
        ]);

        return response()->json($post, 201);

    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'        => 'string|max:255',
            'content'      => 'string',
            'is_published' => 'boolean',
            'tags' => 'array'
        ]);

        $post->update($request->only(['title', 'content', 'is_published']));
        $post->tags()->sync($request->input('tags', []));

        return response()->json($post);
    }

    public function updateTags(Request $request, Post $post)
    {
        $request->validate([
            'tags' => 'array'
        ]);

        $post->tags()->sync($request->input('tags', []));

        return response()->json($post);
    }

    public function detachTags(Request $request, Post $post)
    {
        $request->validate([
            'tags' => 'array'
        ]);

        $post->tags()->detach($request->input('tags', []));

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.',
        ]);
    }
}
