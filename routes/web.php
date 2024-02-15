<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [TodoController::class, 'index'])->name('todo.index');

Route::prefix('todo')->controller(TodoController::class)->name('todo.')->middleware('auth')->group(function () {
  Route::get('/', 'get')->name('get');
  Route::post('/', 'store')->name('store');
  Route::put('{todo}', 'update')->name('update');
  Route::delete('{todo}', 'destroy')->name('destroy');
  Route::put('/{todo}', 'updateOrder')->name('order');
});

require __DIR__.'/auth.php';
