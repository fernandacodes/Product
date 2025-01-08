<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCategoryController;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login'); // Rota de login
    Route::post('register', 'register'); // Rota de registro
    Route::post('logout', 'logout'); // Rota de logout
    Route::post('refresh', 'refresh'); // Rota para refresh do token
});

// Rotas protegidas por autenticação
Route::middleware('auth:api')->group(function () {
    // Rotas para gerenciamento de tarefas e categorias
    Route::post('/task-categories', [TaskCategoryController::class, 'store'])->name('task-categories.store');
    Route::get('/task-categories', [TaskCategoryController::class, 'index'])->name('task-categories.index');
    Route::put('/task-categories/{id}', [TaskCategoryController::class, 'update'])->name('task-categories.update');
    Route::delete('/task-categories/{id}', [TaskCategoryController::class, 'delete'])->name('task-categories.delete');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index'); // Rota para obter todas as tarefas
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'delete'])->name('tasks.delete');

    // Rotas adicionais para tarefas
    Route::get('/tasks/report', [TaskController::class, 'report'])->name('tasks.report');
    Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');
});
