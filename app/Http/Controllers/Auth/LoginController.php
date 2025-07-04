<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Student;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin'; // Change as needed

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the default login method.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // 1. Try login with users table
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user); // Log in as the real user
            session(['admin' => true]); // Set admin session

            return redirect()->intended($this->redirectTo); // wherever you want to redirect admins
        }

        // 2. Try login with students table
        $student = Student::where('email', $credentials['email'])->first();

        if ($student && Hash::check($credentials['password'], $student->password)) {

            if ($student->is_active == 0) {
                return back()->withErrors([
                    'email' => 'Your ID is not activated and is under review.',
                ]);
            }
            $admin = User::where('role', 'admin')->first(); // dummy admin for login context

            if ($admin) {
                Auth::login($admin); // Log in as fake admin
                session(['student_as_admin' => $student->id]); // Set student session

                return redirect()->route('admin.users.show', $student->id);
            }
        }

        // 3. If nothing matched
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }
    /**
     * Override logout to clear the session for student impersonation.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('student_as_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
