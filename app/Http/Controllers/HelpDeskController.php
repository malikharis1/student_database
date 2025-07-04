<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\HelpDesk;
use Illuminate\Support\Facades\Auth;

class HelpDeskController extends Controller
{
    // Show all complaints for logged-in user
    public function index()
    {
        if (session()->has('admin')) {
            $complaints = HelpDesk::latest()->get();
        } elseif (session()->has('student_as_admin')) {
            // Assuming session('student_as_admin') contains the user_id of the student
            $userId = session('student_as_admin');

            // Get the student ID from the user ID
            $studentId = Student::where('id', $userId)->value('id');

            // Get complaints related to that student
            $complaints = HelpDesk::where('user_id', $studentId)->latest()->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('helpdesk.index', compact('complaints'));
    }


    // Store new complaint
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        if (session()->has('student_as_admin')) {
            $userId = session('student_as_admin');
        } else {
            $userId = Auth::id(); // fallback if it's a regular user or admin
        }

        HelpDesk::create([
            'user_id' => $userId,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Complaint submitted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = HelpDesk::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();

        return back()->with('success', 'Status updated successfully.');
    }
}
