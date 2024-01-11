<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectsPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Project $project)
    {
        return $user->is($project->owner);
    }
}
