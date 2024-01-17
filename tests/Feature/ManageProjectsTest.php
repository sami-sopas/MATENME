<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects() : void
    {
        $project =  \App\Models\Project::factory()->create();

        $this->get('/projects')->assertRedirectToRoute('login'); //Acceder al index
        $this->get('/projects/create')->assertRedirectToRoute('login'); //Acceder a crear proyecto
        $this->get('projects/edit')->assertRedirectToRoute('login'); //Acceder a editar proyecto
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
        //$this->signIn();

        //Crear proyecto que le pertenezca
        $project = ProjectFactory::create();

        //Peticion para actualizarlo
        $this->actingAs($project->owner)
                ->patch($project->path(), $attributes = ['title' => 'Changed','description' => 'Changed','notes' => 'Changed',])
                ->assertRedirect($project->path()); //Por ultimo verificar que se redirige a la pagina principal

        $this->get($project->path().'/edit')->assertOk(); //Puede acceder a la vista para editar

        //Asegurarnos que se actualizo viendo la DB
        $this->assertDatabaseHas('projects',$attributes);
    }

    public function test_a_user_can_update_a_projects_general_notes() : void
    {
         //Crear proyecto que le pertenezca
         $project = ProjectFactory::create();

         //Peticion para actualizarlo
         $this->actingAs($project->owner)
                 ->patch($project->path(), $attributes = ['notes' => 'Changed']);

         //Asegurarnos que se actualizo viendo la DB
         $this->assertDatabaseHas('projects',$attributes);
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

    //PENDIENTE
    // public function test_a_user_can_view_their_project(): void
    // {
    //     $project = ProjectFactory::create();

    //     //Ver si puede ver el proyecto
    //     $this->actingAs($project->owner)
    //         ->get($project->path())
    //         ->assertSee($project->title)
    //         ->assertSee($project->description);
    // }

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
        $this->patch($project->path())
            ->assertStatus(403);
    }
}
