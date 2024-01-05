<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = \App\Models\Project::all();

        return view('index', compact('projects'));
    }

    public function store()
    {
        //Validar

        //Persistir
        Project::create(request(['title', 'description']));

        //Redireccionar
        return redirect('/projects');
    }
}
