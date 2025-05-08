<?php

use App\Http\Controllers\EnclosuresController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/enclosures', [EnclosuresController::class, 'index'])->name('list.index');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/enclosures/add', [EnclosuresController::class, 'create'])->name('enclosures.create');
    Route::post('/enclosures/add', [EnclosuresController::class, 'store'])->name('enclosures.store');

    Route::get('/enclosures/{enclosure}/edit', [EnclosuresController::class, 'edit'])->name('enclosures.edit');
    Route::put('/enclosures/{id}', [EnclosuresController::class, 'update'])->name('enclosures.update');

    Route::delete('/enclosures/{id}', [EnclosuresController::class, 'delete'])->name('enclosures.delete');

    Route::get('/animals/create', [AnimalController::class, 'create'])->name('animals.create');
    Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');

    Route::get('/animals/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
    Route::put('/animals/{id}', [AnimalController::class, 'update'])->name('animals.update');

    Route::post('/animals/{id}/archive', [AnimalController::class, 'archive'])->name('animals.archive');

    Route::get('/animals/archived', [AnimalController::class, 'archived'])->name('animals.archived');

    Route::post('/animals/{id}/restore', [AnimalController::class, 'restore'])->name('animals.restore');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/enclosures/{id}', [EnclosuresController::class, 'show'])
    ->name('enclosures.show')
    ->middleware('auth',);

Route::fallback(function() {
    abort(404);
});

require __DIR__.'/auth.php';
