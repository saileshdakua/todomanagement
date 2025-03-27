<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Task;

class AuthController extends Controller
{
    // Show register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phno' => 'required|digits:10|unique:users,phno',
            'gender' => 'required',
            'dob' => 'required|date',
            'username' => 'required|unique:users,username',
            'password' => [
                'required',
                'min:6',
                'regex:/[A-Z]/',      // Uppercase
                'regex:/[a-z]/',      // Lowercase
                'regex:/[0-9]/',      // Numeric
                'regex:/[@$!%*?&]/',  // Special character
            ],
        ], [
            // Custom messages
            'name.required' => 'Full name is required.',
            'name.max' => 'Name must not exceed 255 characters.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'phno.required' => 'Mobile number is required.',
            'phno.digits' => 'Mobile number must be exactly 10 digits.',
            'phno.unique' => 'This mobile number is already registered.',

            'gender.required' => 'Please select your gender.',

            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Please enter a valid date of birth.',

            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.regex' => 'Password must contain an uppercase letter, lowercase letter, number, and special character.',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'phno' => $request->phno,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'remember_token' => bin2hex(random_bytes(32)), // Custom token
        ]);

        $user->save();

        return response()->json(['success' => 'Registration successful!'], 200);
    }


    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();
        // User not found
        if (!$user) {
            return response()->json(['error' => 'Username or email not found.'], 404);
        }

        if ($user && Hash::check($request->password, $user->password)) {
            // Generate a custom authentication token
            $authToken = Str::random(60);
            $user->update(['remember_token' => $authToken]);

            // Store user details in session
            session([
                'auth_token' => $authToken,
                'user_name'  => $user->username,
                'user_email' => $user->email,
                'user_id' => $user->id
            ]);

            return response()->json(['success' => 'Login successful!'], 200);
        } else {
            return response()->json(['error' => 'Invalid password!'], 401);
        }
    }



    public function dashboard(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.form');
        }

        $tasks = Task::where('user_id', $userId)->orderBy('due_date')->get();

        return view('dashboard', compact('tasks'));
    }


    // Handle logout
    public function logout(Request $request)
    {
        $user = User::where('remember_token', Session::get('auth_token'))->first();
        if ($user) {
            $user->update(['remember_token' => null]);
        }

        Session::flush();

        return response()->json(['message' => 'You have been logged out successfully!']);
    }
}
