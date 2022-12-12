<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => auth()->user()?->projects]);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Project $project)
    {
        $this->authorize('member_or_owner', $project);

        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('projects.create');
    }


    /**
     * @throws AuthorizationException
     */
    public function edit(Project $project)
    {
        $this->authorize('member_or_owner', $project);
        return view('projects.edit', ['project' => $project]);

    }

    public function store(ProjectStoreRequest $request)
    {
        $project = auth()->user()?->projects()->create($request->validated());

        return redirect()->route('projects.show', $project);
    }

    public function update(Project $project, ProjectUpdateRequest $request)
    {
        $project->fill($request->validated())->save();

        return redirect()->route('projects.show', $project);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Project $project)
    {
        $this->authorize('owner', $project);

        $project->delete();

        return redirect()->route('projects.index');
    }

}
