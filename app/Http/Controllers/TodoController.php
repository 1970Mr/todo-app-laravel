<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    $validator = Validator::make($request->all(), [
      'text' => 'required|string|max:255',
    ]);
    if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

    $todo = Todo::create($request->all());
    return response()->json($todo, 201);
  }

  public function update(Request $request, Todo $todo)
  {
    $todo->update($request->all());
    return response()->json($todo, 200);
  }

  public function destroy(Todo $todo)
  {
    try {
      $todo->delete();
      return response()->json(null, 204);
    } catch (\Exception $e) {
      return response()->json(['errors' => $e->getMessage()], 422);
    }
  }
}
