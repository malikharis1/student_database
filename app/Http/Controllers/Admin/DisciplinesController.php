<?php

namespace App\Http\Controllers\Admin;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDisciplineRequest;
use App\Http\Requests\StoreDisciplineRequest;
use App\Http\Requests\UpdateDisciplineRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisciplinesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('discipline_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disciplines = Discipline::all();

        return view('admin.disciplines.index', compact('disciplines'));
    }

    public function create()
    {
        abort_if(Gate::denies('discipline_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disciplines.create');
    }

    public function store(StoreDisciplineRequest $request)
    {
        // Get all the validated input data
        $data = $request->all();

        // Flatten semester-wise selected subjects into a single array
        $flattenedSubjects = collect($data['subjects'] ?? [])->flatten()->toArray();

        // Encode to JSON and replace original subjects input
        $data['subjects'] = json_encode($flattenedSubjects);

        // Create the discipline with updated data
        Discipline::create($data);

        return redirect()->route('admin.disciplines.index')->with('success', 'Discipline created successfully with selected subjects.');
    }


    public function edit(Discipline $discipline)
    {
        abort_if(Gate::denies('discipline_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disciplines.edit', compact('discipline'));
    }

    public function update(UpdateDisciplineRequest $request, Discipline $discipline)
    {
        $data = $request->all();

        // Flatten and encode
        $flattenedSubjects = collect($data['subjects'] ?? [])->flatten()->toArray();
        $data['subjects'] = json_encode($flattenedSubjects);

        $discipline->update($data);

        return redirect()->route('admin.disciplines.index')->with('success', 'Discipline updated successfully.');
    }


    public function show(Discipline $discipline)
    {
        abort_if(Gate::denies('discipline_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subjects = json_decode($discipline->subjects, true);

        return view('admin.disciplines.show', compact('discipline', 'subjects'));
    }



    public function destroy(Discipline $discipline)
    {
        abort_if(Gate::denies('discipline_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $discipline->delete();

        return back();
    }

    public function massDestroy(MassDestroyDisciplineRequest $request)
    {
        Discipline::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
