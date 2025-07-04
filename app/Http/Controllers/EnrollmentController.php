<?php

namespace App\Http\Controllers;

use App\Course;
use App\Discipline;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EnrollmentController extends Controller
{
    public function showRegisterForm()
    {
        $courses = Discipline::pluck('name');
        return view('auth.register', compact('courses'));
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date|before:' . now()->subYears(18)->toDateString(),

            'course' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'religion' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Student::create([
            'registration_number' => 'REG-' . strtoupper(uniqid()),
            'name' => $validatedData['name'],
            'father_name' => $validatedData['father_name'],
            'mother_name' => $validatedData['mother_name'],
            'dob' => $validatedData['dob'],
            'course' => $validatedData['course'],
            'gender' => $validatedData['gender'],
            'religion' => $validatedData['religion'],
            'category' => $validatedData['category'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()
            ->back()
            ->with('status', 'Registration successful! Admin will verify your details and notify you via email.')
            ->with('active_tab', 'register');
    }
    public function create(Course $course)
    {
        $breadcrumb = "Enroll in $course->name course";

        return view('enrollment.enroll', compact('course', 'breadcrumb'));
    }

    public function store(Request $request, Course $course)
    {
        if (auth()->guest()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            auth()->login($user);
        }

        $course->enrollments()->create(['user_id' => auth()->user()->id]);

        return redirect()->route('enroll.myCourses');
    }

    public function handleLogin(Course $course)
    {
        return redirect()->route('enroll.create', $course->id);
    }

    public function myCourses()
    {
        $breadcrumb = "My Courses";

        $userEnrollments = auth()->user()
            ->enrollments()
            ->with('course.institution')
            ->orderBy('id', 'desc')
            ->paginate(6);

        return view('enrollment.courses', compact(['breadcrumb', 'userEnrollments']));
    }

    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = Student::findOrFail($id);
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Email updated successfully.');
    }
}
