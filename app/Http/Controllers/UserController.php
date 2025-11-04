<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Handle login logic here
        // Validate incoming request data
        $incomingFields = $request->validate([
            'loginname'=>'required|min:3|max:15',
            'loginpassword'=>'required'
        ]);
        // If validation fails, Laravel will automatically redirect back to the previous page.
        // $request->validate() returns only the validated fields, we store them in $incomingFields

        // We need to map the incoming fields to the expected keys for authentication 
        $incomingFields = [
            'name' => $incomingFields['loginname'],
            'password' => $incomingFields['loginpassword']
        ];
        
        // Now we authenticate using these fields.
        if (auth()->attempt($incomingFields)) {
            // Authentication passed...

            $request->session()->regenerate(); // Regenerate session to prevent fixation
            return redirect('/')->with('success', 'You are now logged in!'); // Redirect to homepage with success message
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Redirect back with error message
    }

    public function logout(Request $request)
    {
        auth()->logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect('/')->with('success', 'You have been logged out successfully.'); // Redirect to homepage with success message
    }
    
    public function register(Request $request)
    {
        // Handle registration logic here
        
        $incomingFields = $request->validate([
            'name'=>'required|min:3|max:15|unique:users,name', // unique:users,name means the name field in the users table must be unique
            // we can also write it using 'Rule' class like this: 'name'=>['required','min:3','max:15',Rule::unique('users','name')]
            'email'=>'required|email|unique:users,email', // we can define multiple rules separated by |
            'password'=>['required','min:3'], // we can also define rules as an array
        ]);
        //If the validation above fails, Laravel will automatically redirect back to the previous page.

        $incomingFields['password'] = bcrypt($incomingFields['password']); // Hash the password before storing it
        // We give the password field a new value, which is the hashed version of the password.
        $user = User::create($incomingFields); // Create a new user record in the users table of the database.
        // User is an Eloquent model representing the "users" table that was created by the command "php artisan migrate".
        auth()->guard()->login($user); // Log the user in after registration
        // Redirect them to the homepage with a success message
        return redirect('/')->with('success', 'Welcome to our community!');
    }
}
