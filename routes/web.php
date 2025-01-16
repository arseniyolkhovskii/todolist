<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Label\LabelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Task\TaskController;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [TaskController::class, 'index'])->name('tasks.index');



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('tasks', TaskController::class)->except(['index']);
Route::resource('categories', CategoryController::class);
Route::resource('labels', LabelController::class);
Route::get('/categories/tasks/{id}', [CategoryController::class, 'showTasks'])->name('categories.showTasks');
Route::get('/labels/tasks/{id}', [LabelController::class, 'showTasks'])->name('labels.showTasks');


require __DIR__.'/auth.php';
