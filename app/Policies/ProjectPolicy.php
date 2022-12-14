<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user own the Project.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function owner(User $user, Project $project)
    {
        return $user->id == $project->owner_id;
    }

    public function member(User $user, Project $project)
    {
        return $project->members()->where(['user_id' => $user->id])->exists();
    }

    public function member_or_owner(User $user, Project $project)
    {
        return $this->owner($user, $project) || $this->member($user, $project);
    }


}
