<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTaskStoreRequest;
use App\Http\Requests\ProjectTaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{

    public function store(Project $project, ProjectTaskStoreRequest $request)
    {
        $this->authorize('owner', $project);

        $project->addTask($request->validated('body'));

        return redirect()->route('projects.show', $project);

    }

    public function update(Project $project, Task $task, ProjectTaskUpdateRequest $request)
    {
        $this->authorize('owner', $project);

        $task->fill($request->validated())->save();
        
        return redirect()->route('projects.show', $project);

    }
}
