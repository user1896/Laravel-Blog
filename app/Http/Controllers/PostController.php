<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function updatePost(Request $request, Post $post) // $post is automatically resolved by Laravel based on the {post} route parameter, and $request contains the incoming HTTP request data.
    {
        if (auth()->id() != $post->user_id) {
            abort(403); // If the authenticated user is not the owner of the post, abort with a 403 Forbidden response.
        }

        // Validate incoming request data
        $incomingFields = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:3'
        ]);
        // If validation fails, Laravel will automatically redirect back to the previous page.

        // Sanitize input to prevent XSS attacks
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // Update the specified post with the validated and sanitized data
        $post->update($incomingFields);

        return redirect('/')->with('successPost', 'Post updated successfully!'); // Redirect to homepage with success message
    }

    public function showEditScreen(Post $post) // Laravel automatically resolves the Post model based on the {post} route parameter, so now we have the Post instance of the specified id.
    {
        if (auth()->id() != $post->user_id) {
            abort(403); // If the authenticated user is not the owner of the post, abort with a 403 Forbidden response.
        }
        // a better way to do this is via Policies, but this is simpler for now.

        // Show the edit form for the specified post
        return view('edit-post', ['post' => $post]);
    }

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

        return redirect('/')->with('successPost', 'Post created successfully!'); // Redirect to homepage with success message
    }
}
