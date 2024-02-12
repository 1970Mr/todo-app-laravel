<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [TodoController::class, 'index'])->name('todo.index');

Route::prefix('todo')->controller(TodoController::class)->name('todo.')->group(function () {
  Route::get('/', 'get')->name('get');
  Route::post('/', 'store')->name('store');
  Route::put('{todo}', 'update')->name('update');
  Route::delete('{todo}', 'destroy')->name('destroy');
});

require __DIR__.'/auth.php';
