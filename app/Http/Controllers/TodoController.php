<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TodoController extends Controller
{
  public function index()
  {
    $todoList = Todo::orderBy('created_at', 'desc')->get();
    return Inertia::render('HomePage', compact('todoList'));
  }

  public function store(Request $request)
  {
    // Todo: validation
    $todo = Todo::create($request->all());
    return response()->json($todo, 201);
  }

  public function update(Request $request, Todo $todo)
  {
    // Todo: validation
    $todo->update($request->all());
    return response()->json($todo, 200);
  }

  public function destroy(Todo $todo)
  {
    $todo->delete();
    return response()->json(null, 204);
  }
}
