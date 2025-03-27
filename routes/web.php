<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\TokenAuthMiddleware;
use Illuminate\Support\Facades\Route;

// ------------------------
// Auth Routes
// ------------------------

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// ------------------------
// Protected Routes (Requires Token)
// ------------------------

Route::middleware([TokenAuthMiddleware::class])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Task Routes (CRUD)
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Change Status Route
    Route::post('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
