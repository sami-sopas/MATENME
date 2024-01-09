<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {
        $this->signIn();

        $project = \App\Models\Project::factory()->raw();

        $project = auth()->user()->projects()->create($project);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
                ->assertSee('Test task');
    }

    public function test_a_task_requires_a_body()
    {
        //Inicio sesion
        $this->signIn();

        //Crear un projecto
        $project = auth()->user()->projects()->create(
            \App\Models\Project::factory()->raw()
        );

        //Se crea un Task con un body vacio
        $attributes = \App\Models\Task::factory()->raw(['body' => '']);

        //Hacer un post request para guardar el task de ese proyecto
        $this->post($project->path() . '/tasks')->assertSessionHasErrors('body');
    }

}
