<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

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


// Projects
Route::get('/', [ProjectController::class, 'index']);
Route::get('projects/{id}', [ProjectController::class, 'show']);
Route::post('projects', [ProjectController::class, 'store']);
Route::post('projects/{id}/update', [ProjectController::class, 'update']);
Route::delete('projects/{id}/destroy', [ProjectController::class, 'destroy']);

// Tasks
Route::get('tasks/{id}', [TaskController::class, 'show']);
Route::post('tasks', [TaskController::class, 'store']);
Route::post('tasks/{id}/update', [TaskController::class, 'update']);
Route::delete('tasks/{id}/destroy', [TaskController::class, 'destroy']);
