<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('userId')) {
            $query->where('userId', $request->query('userId'));
        }

        $posts = $query->get();

        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'userId' => 'required|integer',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $post = Post::create($validatedData);

            \Illuminate\Support\Facades\DB::commit();

            return response()->json($post, 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return response()->json(['message' => 'Failed to create post', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'userId' => 'required|integer',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $post = Post::findOrFail($id);
            $post->update($validatedData);

            \Illuminate\Support\Facades\DB::commit();

            return response()->json($post, 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return response()->json(['message' => 'Failed to update post', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $post = Post::findOrFail($id);
            $post->delete();

            \Illuminate\Support\Facades\DB::commit();

            return response()->json(['message' => 'Post deleted successfully'], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return response()->json(['message' => 'Failed to delete post', 'error' => $e->getMessage()], 500);
        }
    }

    public function showComments($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return response()->json($post, 200);
    }
}
