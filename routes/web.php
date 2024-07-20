<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index'])->name('todos.index');

Route::prefix('todos')
  ->controller(TodoController::class)
  ->name('todos.')
  ->middleware('auth')
  ->group(function () {
    Route::get('/', 'get')->name('get');
    Route::post('/', 'store')->name('store');
    Route::put('{todo}', 'update')->name('update');
    Route::delete('{todo}', 'destroy')->name('destroy');
    Route::put('/update-position/{todo}', 'updatePosition')->name('update-position');
  });

require __DIR__ . '/auth.php';
