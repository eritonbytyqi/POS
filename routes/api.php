<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;


Route::apiResource('projects',ProjectController::class);
Route::post('tasklists/reorder', [TaskListController::class, 'reorderTaskLists']);
Route::apiResource('tasklists',TaskListController::class);

Route::post('tasks/reorder', [TaskController::class, 'reorderTasks']);
Route::post('tasks/{taskId}/add-user',[TaskController::class,'addUserToTask']);
Route::delete('tasks/{taskId}/delete-user',[TaskController::class,'deleteUserFromTask']);
Route::apiResource('tasks',TaskController::class);
Route::apiResource('users',UserController::class);
// Route::middleware('auth:sanctum')->get('/users/deleted', [UserController::class, 'getDeletedUsers']);

Route::post('users/{id}/restore', [UserController::class, 'restoreDeletedUser']);
Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);


