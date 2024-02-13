<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TodoController extends Controller
{
  public function index()
  {
    return Inertia::render('HomePage');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), ['text' => 'required|string|max:255',]);
    if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
    $todo = auth()->user()->todos()->create($request->all());
    return response()->json($todo, 201);
  }

  public function update(Request $request, Todo $todo)
  {
    try {
      $this->isAuthorized($todo, 'update');
      $todo->update($request->all());
      return response()->json($todo, 200);
    } catch (\Exception $e) {
      return response()->json(['errors' => $e->getMessage()], 422);
    }
  }

  public function destroy(Todo $todo)
  {
    try {
      $this->isAuthorized($todo, 'delete');
      $todo->delete();
      return response()->json(null, 204);
    } catch (\Exception $e) {
      return response()->json(['errors' => $e->getMessage()], 422);
    }
  }

  public function get(Request $request)
  {
    $todos = auth()->user()->todos()->orderBy('created_at', 'desc')->paginate($request->perPage);
    return response()->json($todos, 200);
  }

  private function isAuthorized(Todo $todo, String $action)
  {
    if ($todo->user_id !== auth()->id())  return throw new \Exception("You are not authorized to $action this todo.");
  }
}
