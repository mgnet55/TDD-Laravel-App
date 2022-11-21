<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
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
        if ($project->owner_id != auth()->id()) {
            abort(404);
        }
        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('projects.create');
    }


    public function store(ProjectStoreRequest $request)
    {
        auth()->user()?->projects()->create($request->validated());

        return redirect('/projects');
    }
}
