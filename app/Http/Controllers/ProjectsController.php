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
        $attributes = request()->validate([
            'title' => 'required',
             'description' => 'required',
            ]);

        $attributes['owner_id'] = auth()->id();

        //dd($attributes); Imprime en consola omg

        //Persistir
        //Project::create($attributes);
        auth()->user()->projects()->create($attributes);

        //Redireccionar
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        //LO que se uso para testear nomas
        //$project = Project::find(request('project'));

        //Verifica si dos modelos son iguales
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }

        /* Anterior metodo
         if(auth()->user()->id != $project->owner_id){
             abort(403);
         }
         */

        return view('project.show', compact('project'));
    }
}
