<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTaskStoreRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function index(Project $project)
    {

    }

    public function store(Project $project ,ProjectTaskStoreRequest $request)
    {
        $project->addTask($request->validated('body'));
        return redirect()->route('projects.show',$project);

    }
}