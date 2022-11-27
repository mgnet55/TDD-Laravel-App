<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => auth()->user()?->projects]);
    }

    public function show(Project $project)
    {
        $this->authorize('owner', $project);

        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('projects.create');
    }


    public function store(ProjectStoreRequest $request)
    {
        $project = auth()->user()?->projects()->create($request->validated());

        return redirect()->route('projects.show', $project);
    }

    public function update(Project $project, ProjectUpdateRequest $request)
    {
        $this->authorize('owner', $project);

        $project->update($request->validated());

        return redirect()->route('projects.show', $project);
    }

}
