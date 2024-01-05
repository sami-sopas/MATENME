<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = \App\Models\Project::all();

        return view('project.index', compact('projects'));
    }

    public function store()
    {
        //Validar
        $attributes = request()->validate([
            'title' => 'required',
             'description' => 'required'
            ]);

        //Persistir
        Project::create($attributes);

        //Redireccionar
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        //LO que se uso para testear nomas
        //$project = Project::find(request('project'));

        return view('project.show', compact('project'));
    }
}
