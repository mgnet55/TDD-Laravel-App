<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTaskStoreRequest;
use App\Http\Requests\ProjectTaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function index(Project $project)
    {

    }

    public function store(Project $project, ProjectTaskStoreRequest $request)
    {
        if ($project->owner->isNot(auth()->user())) {
            abort(403);
        }

        $project->addTask($request->validated('body'));

        return redirect()->route('projects.show', $project);

    }

    public function update(Project $project, Task $task, ProjectTaskUpdateRequest $request)
    {
        if ($project->owner->isNot(auth()->user())) {
            abort(403);
        }

        $task->update([
            'body' => $request->validated('body'),
            'completed' => $request->safe()->has('completed'),
        ]);

        return redirect()->route('projects.show', $project);

    }
}
