<?php

use App\Models\Project;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/projects',[ProjectsController::class, 'index'])->name('projects.index');

Route::post('/projects',[ProjectsController::class, 'store'])->name('projects.store');

Route::get('/projects/{project}',[ProjectsController::class, 'show'])->name('projects.show');

// Route::get('/projects', function () {
//     $projects = App\Models\Project::all();
//     return view('projects.index', compact('projects'));
// });

// Route::post('/projects', function () {
//     App\Models\Project::create(request(['title', 'description']));
// });
