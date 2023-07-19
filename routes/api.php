<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;

Route::middleware('auth:sanctum')->group(function() {

    Route::apiResource('todo-list', TodoListController::class);
    Route::apiResource('todo-list.task', TaskController::class)->except('show')->shallow();
    Route::apiResource('label', LabelController::class);

    Route::get('/service/connect/{service}', [ServiceController::class, 'connect'])->name('service.connect');
    Route::post('/service/callback', [ServiceController::class, 'callback'])->name('service.callback');
    Route::post('/web-service/{web_service}', [ServiceController::class, 'store'])->name('web-service.store');
});


// Route::get('todo-list', [TodoListController::class, 'index'])->name('todo-list');
// Route::get('todo-list/{todolist}', [TodoListController::class, 'show'])->name('todo-list.show');
// Route::post('todo-list', [TodoListController::class, 'store'])->name('todo-list.store');

// Route::delete('todo-list/{list}', [TodoListController::class, 'destroy'])->name('todo-list.destroy');
// Route::patch('todo-list/{list}', [TodoListController::class, 'update'])->name('todo-list.update');



// Route::get('task', [TaskController::class, 'index'])->name('task.index');
// Route::post('task', [TaskController::class, 'store'])->name('task.store');
// Route::delete('task/{task}', [TaskController::class, 'destroy'])->name('task.destroy');

Route::post('/register', RegistrationController::class)->name('user.register');
Route::post('/login', LoginController::class)->name('user.login');