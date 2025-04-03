<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/users", [UserController::class, "getAll"]);
Route::post("/users", [UserController::class, "create"]);
Route::put("/users/{id}", [UserController::class, "update"]);
Route::delete("/users/{id}", [UserController::class, "delete"]);


Route::apiResource("/posts", PostController::class);
Route::apiResource("/comments", CommentController::class);
