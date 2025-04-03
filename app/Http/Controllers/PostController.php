<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->query("per_page", 10);
            $page = $request->query("page", 0);
            $offset = $page * $perPage;

            $posts = Post::with('user:id,name')->skip($offset)->take($perPage)->get()->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                    'published_at' => $post->published_at,
                    'user_name' => $post->user->name,
                ];
            });

            return response()->json($posts);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(PostRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['published_at'] = now();
            $post = Post::create($validatedData);
            return response()->json($post);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(PostRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            unset($validatedData['published_at']);
            $post = Post::find($id);
            if (!$post) {
                return response()->json(["error" => "Post no encontrado"], Response::HTTP_NOT_FOUND);
            }
            $post->update($validatedData);
            return response()->json(["message" => "Post actualizado exitosamente", "post" => $post]);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy(string $id)
    {
        try {
            $post = Post::find($id);
            if (!$post) {
                return response()->json(["error" => "Post no encontrado"], Response::HTTP_NOT_FOUND);
            }
            $post->delete();
            return response()->json(["message" => "Post eliminado"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
