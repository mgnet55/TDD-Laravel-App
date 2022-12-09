<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTaskStoreRequest;
use App\Http\Requests\ProjectTaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectTasksController extends Controller
{

    public function store(Project $project, ProjectTaskStoreRequest $request)
    {
        $this->authorize('owner', $project);

        $project->addTask($request->validated('body'));

        return redirect()->route('projects.show', $project);

    }

    /**
     * @throws AuthorizationException
     */
    public function update(Project $project, Task $task, ProjectTaskUpdateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('owner', $project);

        $task->fill($request->safe()->except('completed'))->save();

        if ($task->completed !== ($completed = $request->validated('completed'))) {
            $completed ? $task->complete() : $task->incomplete();

        }


        return redirect()->route('projects.show', $project);

    }
}
