<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationsController extends Controller
{

    public function invite(Project $project, ProjectInvitationRequest $request)
    {

        $user = User::whereEmail($request->validated('email'))->first();

        $project->invite($user);

        return redirect()->route('projects.show', $project);

    }
}
