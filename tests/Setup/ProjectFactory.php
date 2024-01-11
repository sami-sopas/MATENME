<?php

namespace Tests\Setup;

/* Esta clase es para evitar escribir
   codigo repetido en los tests */

class ProjectFactory
{
    protected $tasksCount = 0;
    protected $user;

    //Fluent api?
    public function withTasks($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = \App\Models\Project::factory()->create([
            //Si no se envia un usuario signIn en ownedBy, creara uno nuevo
            'owner_id' => $this->user ?? \App\Models\User::factory()->create()
        ]);

        \App\Models\Task::factory($this->tasksCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}

//app(ProjectFactory::class)->create();
