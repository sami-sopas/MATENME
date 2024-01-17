<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('project.index', compact('projects'));
    }

    public function store()
    {
        //Validar
        //$attributes = $this->validate();

        //$attributes['owner_id'] = auth()->id();

        //dd($attributes); //Imprime en consola omg

        //Persistir
        //Project::create($attributes);
        $project = auth()->user()->projects()->create($this->validateRequest());

        //Redireccionar
        return redirect($project->path());
    }

    /*
    * @return array
    */
    protected function validateRequest()
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable',
            ]);

        return $attributes;
    }

    public function edit(Project $project)
    {
        return view('project.edit', compact('project'));
    }

    public function update(Project $project)
    {
         //Si el usuario autenticado no es el dueño del proyecto
        // if(auth()->user()->isNot($project->owner)){
        //     abort(403);
        // }

        //Se cambio a una policy
        $this->authorize('update', $project);

        //Validar
        //$attributes = $this->validate();

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    public function show(Project $project)
    {
        //LO que se uso para testear nomas
        //$project = Project::find(request('project'));

        $this->authorize('update', $project);

        /* Anterior metodo
         if(auth()->user()->id != $project->owner_id){
             abort(403);
         }
         */

        return view('project.show', compact('project'));
    }

    public function create()
    {
        return view('project.create');
    }
}
