<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Handle registration logic here
        $incomingFields = $request->validate([
            'name'=>'required',
            'email'=>'required|email', // we can define multiple rules separated by |
            'password'=>['required','min:3'], // we can also define rules as an array
        ]);
        //If the validation above fails, Laravel will automatically redirect back to the previous page.

        $incomingFields['password'] = bcrypt($incomingFields['password']); // Hash the password before storing it
        // We give the password field a new value, which is the hashed version of the password.
        User::create($incomingFields); // Create a new user record in the users table of the database.
        // User is an Eloquent model representing the "users" table that was created by the command "php artisan migrate".
        
        // For now, just return a simple message
        return "Hello from our controller";
    }
}
