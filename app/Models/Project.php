<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        //Un projecto tiene muchas tareas
        return $this->hasMany(Task::class);
    }

    /*
        Este metodo recibe el mensaje del task
        y desde aqui lo crea y lo asocial al projecto
    */
    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }
}
