<?php

namespace App\Http\Controllers;

use App\HelpDesk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpDeskController extends Controller
{
    public function index()
    {
        $tickets = HelpDesk::where('user_id', Auth::id())->latest()->get();
        return view('helpdesk.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        HelpDesk::create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Your complaint has been submitted.');
    }
}
