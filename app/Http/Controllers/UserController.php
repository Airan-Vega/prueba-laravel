<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 0);
            $offset = $page * $perPage;

            $users = User::skip($offset)->take($perPage)->get();
            return response()->json($users);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = User::create($validatedData);
            return response()->json($user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update(UserRequest $request, string $id)
    {

        try {
            $validatedData = $request->validated();
            $user = User::find($id);
            if (!$user) {
                return response()->json(["error" => "Usuario no encontrado"], Response::HTTP_NOT_FOUND);
            }
            $user->update($validatedData);
            return response()->json(["message" => "Usuario actualizado exitosamente", "user" => $user]);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(string $id)
    {

        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(["error" => "Usuario no encontrado"], Response::HTTP_NOT_FOUND);
            }
            $user->delete();
            return response()->json(["message" => "Usuario eliminado"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
