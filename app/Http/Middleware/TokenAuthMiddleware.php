<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class TokenAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = Session::get('auth_token');

        // Check if token exists and is valid
        $user = User::where('remember_token', $token)->first();

        if (!$token || !$user) {
            // Optional: clear session if token is invalid
            Session::forget('auth_token');
            Session::flush();

            return redirect()->route('login.form')->with('error', 'Unauthorized access. Please log in.');
        }

        // Optional: share authenticated user across views if needed
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}
