<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('todo')->controller(TodoController::class)->group(function () {
  Route::post('/', 'store')->name('todo.store');
  Route::put('{todo}', 'update')->name('todo.update');
  Route::delete('{todo}', 'destroy')->name('todo.destroy');
});
