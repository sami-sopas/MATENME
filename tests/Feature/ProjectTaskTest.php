<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_add_tasks_to_projects()
    {
        $project = \App\Models\Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        //Iniciamos seseion
        $this->signIn();

        //Creamos un proecto
        $project = \App\Models\Project::factory()->create();

        //Intengrar agregar un task a ese proyecto
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
                ->assertStatus(403); //Error cuando no tienes permisos

        //Verificar que eso no se haya agregado a la base de datos
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_a_project_can_have_tasks()
    {
        // $this->signIn();

        // $project = auth()->user()->projects()->create(
        //     \App\Models\Project::factory()->raw()
        // );

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
                ->assertSee('Test task');
    }

    public function test_a_task_can_be_updated()
    {

        //Agregando el Facades\ se quita el error de non static
        $project = ProjectFactory::withTasks(1)->create();
                    //->ownedBy($this->signIn())


        //Este codigo se modularizo en la clase ProjectFactory

        //Iniciamos sesion
        //$this->signIn();

        //Crear un proyecto perteneciente a ese usuario
        // $project = auth()->user()->projects()->create(
        //     \App\Models\Project::factory()->raw()
        // );

        // //Le creamos un task a ese proyecto
        // $task = $project->addTask('test task');

        //Actualizar el task
        $this->actingAs($project->owner)
                ->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        //Ver si se actualizo en la BD, tabla task, columna tal
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);

    }

    public function test_a_task_requires_a_body()
    {
        // //Inicio sesion
        // $this->signIn();

        // //Crear un projecto
        // $project = auth()->user()->projects()->create(
        //     \App\Models\Project::factory()->raw()
        // );

        $project = ProjectFactory::create();

        //Se crea un Task con un body vacio
        $attributes = \App\Models\Task::factory()->raw(['body' => '']);

        //Hacer un post request para guardar el task de ese proyecto y ver que da error por el body*/
        $this->ActingAs($project->owner)
            ->post($project->path() . '/tasks')
            ->assertSessionHasErrors('body');
    }

    public function test_only_the_owner_of_a_project_may_update_a_task()
    {
        //Iniciamos seseion
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        // //Creamos un proyecto que NO NOS PERTENECE
        // $project = \App\Models\Project::factory()->create();

        // //Le creamos un task a ese proyecto
        // $task = $project->addTask('test task');

        //Enviamos una patch request para actualizar el task
        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
                ->assertStatus(403); //Error cuando no tienes permisos

        //Verificar que eso no se haya agregado a la base de datos
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

}
