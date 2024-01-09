<?php

namespace Tests\Unit;

use Tests\TestCase;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */

    /*
    Para evitar reescribir cuando cambie el path
    por ejemplo /proyect/id /proyect/name proyect/slug etc
    */
    public function test_it_has_a_path(): void
    {
        $project = \App\Models\Project::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    public function test_it_belongs_to_an_owner(): void
    {
        //Creamos un projecto
        $project = \App\Models\Project::factory()->create();

        $this->assertInstanceOf('App\Models\User', $project->owner);
    }

    public function test_it_can_add_a_task(): void
    {
        $project = \App\Models\Project::factory()->create();

        $task = $project->addTask('Test task');

        //Comprobar que contenga el task que le creamos
        $this->assertTrue($project->tasks->contains($task));

        //Esperar que haya al menos un task perteneciente al projecto
        $this->assertCount(1,$project->tasks);
    }
}
