<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        // Validate incoming request data
        $incomingFields = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:3'
        ]);
        // If validation fails, Laravel will automatically redirect back to the previous page.

        // Sanitize input to prevent XSS attacks
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // $incomingFields['user_id'] = $request->user()->id; // Associate "post" with the authenticated "user"
        $incomingFields['user_id'] = auth()->id();

        // Create a new post associated with the authenticated user
        Post::create($incomingFields); // Create a new post record in the database

        return redirect('/')->with('successPostCreation', 'Post created successfully!'); // Redirect to homepage with success message
    }
}
