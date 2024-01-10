<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_project() : void
    {
        //Crear la task
        $task = \App\Models\Task::factory()->create();

        //Verificar que existe la relacion al comparar las instancias
        $this->assertInstanceOf('App\Models\Project', $task->project);
    }

    /**
     * A basic unit test example.
     */
    public function test_it_has_a_path(): void
    {


        //Crear un task
        $task = \App\Models\Task::factory()->create();

        //Verificar que sean iguales los paths
        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}
