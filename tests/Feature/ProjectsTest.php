<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_only_authenticated_users_can_create_projects() : void
    {
        $attributes =  \App\Models\Project::factory()->raw();

        $this->post('/projects', $attributes)->assertRedirectToRoute('login');
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_create_a_project(): void
    {
        $this->actingAs(\App\Models\User::factory()->create());

        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        //Con los datos que se comparara el test, y verifica que se redireccione
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        //Verificar que se creo el registro en la DB
        $this->assertDatabaseHas('projects', $attributes);

        //Con una peticion test ver si se creo
        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_project_requires_a_title(): void
    {
        //Crear usuario para que estemos "autenticados"
        $this->actingAs(\App\Models\User::factory()->create());

        $attributes = \App\Models\Project::factory()->raw(['title' => '']);


        //Asegurar que haya un error en la sesion al no tener titulo
        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description(): void
    {
        $this->actingAs(\App\Models\User::factory()->create());

        //Asegurar que haya un error en la sesion al no tener titulo
        $this->post('/projects',[])->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_a_project(): void
    {
        $this->withoutExceptionHandling(); //Quitar mensadas

        //Anterior: factory('App\Models\Project')->create();

        //Nuevo
        $project = \App\Models\Project::factory()->create();

        //Ver si puede ver el proyecto
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
}
