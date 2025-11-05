<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    $posts = auth()->check() ? auth()->user()->usersCoolPosts()->latest()->get() : []; // if user is authenticated, get their posts, else return empty array
    return view('home', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

// Blog posts related routes
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']); // Show edit form for a specific post
Route::put('/edit-post/{post}', [PostController::class, 'updatePost']); // Handle post edit
