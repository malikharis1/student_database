<?php

namespace App\Http\Controllers\Admin;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Institution;
use App\Role;
use App\Student;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentStatusChanged;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = Student::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $institutions = Institution::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('roles', 'institutions'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(Student $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = Student::findOrFail($id); // instead of Student

        $user->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'course' => $request->course,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'category' => $request->category,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->back()->with('status', 'Profile updated successfully!');
    }


    public function show(Student $user)
    {
        $discipline = Discipline::where('name', $user->course)->first();
        $selectedSubjects = $discipline ? json_decode($discipline->subjects, true) : [];

        return view('admin.users.show', compact('user', 'selectedSubjects'));
    }


    public function destroy(Student $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back()->with('message', 'Student deleted successfully.');
    }


    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function toggleStatus(Student $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'Activated' : 'Deactivated';

        // Send email
        Mail::to($user->email)->send(new StudentStatusChanged($user, $statusText));

        return redirect()->back()->with('status', "Student has been {$statusText} and notified via email.");
    }
}
