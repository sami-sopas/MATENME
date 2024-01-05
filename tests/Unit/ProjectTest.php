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
}
