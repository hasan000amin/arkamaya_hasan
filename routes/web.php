<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/project', [ProjectController::class, 'index'])->name('project');
    Route::post('/project/delete', [ProjectController::class, 'deleteMultiple'])->name('project.delete.multiple');
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{id}', [ProjectController::class, 'edit'])->name('project.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
