<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->query("per_page", 10);
            $page = $request->query("page", 0);
            $offset = $page * $perPage;

            if ($perPage <= 0 || $page < 0) {
                return response()->json([
                    "error" => "Los parámetros de paginación deben ser positivos."
                ], Response::HTTP_BAD_REQUEST);
            }

            $comments = Comment::with('user:id,name', 'post:id,title')->skip($offset)->take($perPage)->get()->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'date' => $comment->date,
                    'user_name' => $comment->user->name,
                    'post_title' => $comment->post->title
                ];
            });

            return response()->json($comments);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(CommentRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['date'] = now();
            $comment = Comment::create($validatedData);
            return response()->json($comment);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(CommentRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            unset($validatedData['date']);
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json(["error" => "Comentario no encontrado"], Response::HTTP_NOT_FOUND);
            }
            $comment->update($validatedData);
            return response()->json(["message" => "Comentario actualizado exitosamente", "comment" => $comment]);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy(string $id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json(["error" => "Comentario no encontrado"], Response::HTTP_NOT_FOUND);
            }
            $comment->delete();
            return response()->json(["message" => "Comentario eliminado"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
