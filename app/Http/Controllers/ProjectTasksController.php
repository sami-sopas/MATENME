<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        //Verificar que sea el dueño del proyecto
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project,Task $task)
    {
        //Verificar que sea el dueño del proyecto
        if(auth()->user()->isNot($task->project->owner)){
            abort(403);
        }

        //Validar
        request()->validate([
            'body' => 'required'
        ]);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed'),
        ]);

        return redirect($project->path());
    }
}
