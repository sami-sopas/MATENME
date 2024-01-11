<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects() : void
    {
        $project =  \App\Models\Project::factory()->create();

        $this->get('/projects')->assertRedirectToRoute('login'); //Acceder al index
        $this->get('/projects/create')->assertRedirectToRoute('login'); //Acceder a crear proyecto
        $this->get($project->path())->assertRedirectToRoute('login'); //Acceder a proyecto especifico
        $this->post('/projects', $project->toArray())->assertRedirect('login'); //Crear a un proyecto
    }

    //Estos se fusionaorn en un solo test, el de cannot create projects
    // public function test_guests_cannot_view_projects() : void
    // {
    //     $this->get('/projects')->assertRedirectToRoute('login');
    // }

    // public function test_guests_cannot_view_a_single_project() : void
    // {
    //     $project = \App\Models\Project::factory()->create();

    //     $this->get($project->path())->assertRedirectToRoute('login');
    // }

    public function test_guests_may_not_view_projects() : void
    {

        $this->get('/projects')->assertRedirectToRoute('login');
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_create_a_project(): void
    {
        $this->withoutExceptionHandling();

        //$this->actingAs(\App\Models\User::factory()->create());

        //Se llama al metodo de TestCase.php y nos ahorramos el actingAs
        $this->signIn();

        //Existe la pagina para crear proyectos
        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.',
        ];

        //Con los datos que se comparara el test, realizar la peticion
        $response = $this->post('/projects', $attributes);

        //Encontrar el proyecto que se creo
        $project = Project::where($attributes)->first();

        //Verificar que se redirigio a ese proyecto
        $response->assertRedirect($project->path());

        //Verificar que se creo el registro en la DB
        $this->assertDatabaseHas('projects', $attributes);

        //Ver que esten los datos en la pagina
        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_user_can_update_a_project() : void
    {
        //Crear usuario para que estemos "autenticados"
        $this->signIn();

        $this->withoutDeprecationHandling();

        //Crear proyecto que le pertenezca
        $project = \App\Models\Project::factory()->create(['owner_id' => auth()->id()]);

        //Peticion para actualizarlo
        $this->patch($project->path(), [
            'notes' => 'Changed',
        ])->assertRedirect($project->path()); //Por ultimo verificar que se redirige a la pagina principal

        //Asegurarnos que se actualizo viendo la DB
        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    public function test_a_project_requires_a_title(): void
    {
        //Crear usuario para que estemos "autenticados"
        $this->signIn();

        $attributes = \App\Models\Project::factory()->raw(['title' => '']);

        //Asegurar que haya un error en la sesion al no tener titulo
        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description(): void
    {
        $this->signIn();

        $attributes = \App\Models\Project::factory()->raw(['description' => '']);

        //Asegurar que haya un error en la sesion al no tener titulo
        $this->post('/projects',$attributes)->assertSessionHasErrors('description');
    }

    /*
    public function test_a_user_can_view_their_project(): void
    {

        //Autenticar al usuario
        $this->signIn();
        //$this->be(\App\Models\User::factory()->create());

        $this->withoutExceptionHandling(); //Quitar mensadas

        //Anterior: factory('App\Models\Project')->create();

        //Crear proyecto, y asignarlo como suyo
        $project = \App\Models\Project::factory()->create(['owner_id' => auth()->id()]);

        //Ver si puede ver el proyecto
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }*/

    public function test_an_authenticated_user_cannot_view_the_project_of_others(): void
    {

        //Autenticar al usuario
        $this->signIn();

        //$this->withoutExceptionHandling(); //Si la dejo da http exeption

        //Anterior: factory('App\Models\Project')->create();

        //Crear proyecto PERO no asignarlo como suyo
        $project = \App\Models\Project::factory()->create();

        //Intentar entrar a ese proyecto no mio
        $this->get($project->path())
            ->assertStatus(403);
    }

    public function test_an_authenticated_user_cannot_update_the_project_of_others(): void
    {

        //Autenticar al usuario
        $this->signIn();

        //$this->withoutExceptionHandling(); //Si la dejo da http exeption

        //Anterior: factory('App\Models\Project')->create();

        //Crear proyecto PERO no asignarlo como suyo
        $project = \App\Models\Project::factory()->create();

        //Intentar actualizar ese proyecto no mio
        $this->patch($project->path(),[])
            ->assertStatus(403);
    }
}
