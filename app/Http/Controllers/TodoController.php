<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class TodoController extends Controller
{
  public function index(): Response
  {
    return Inertia::render('HomePage');
  }

  public function store(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), ['text' => 'required|string|max:255',]);
    if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
    $todo = auth()->user()->todos()->create($request->all());
    $lastOrder = auth()->user()->todos()->orderBy('order', 'desc')->first()->order;
    $todo->order = $lastOrder + 1;
    $todo->save();
    return response()->json($todo, 201);
  }

  public function update(Request $request, Todo $todo): JsonResponse
  {
    logger($todo);
    try {
      $this->isAuthorized($todo, 'update');
      $todo->update($request->all());
      return response()->json($todo);
    } catch (AuthorizationException $e) {
      return response()->json(['errors' => $e->getMessage()], 422);
    }
  }

  public function destroy(Todo $todo): JsonResponse
  {
    try {
      $this->isAuthorized($todo, 'delete');
      $todo->delete();
      return response()->json(null, 204);
    } catch (AuthorizationException $e) {
      return response()->json(['errors' => $e->getMessage()], 422);
    }
  }

  public function get(Request $request): JsonResponse
  {
    $todos = auth()->user()->todos();
    if (isset($request->filteredData['filter'])) {
      $filter = $this->filter($request->filteredData['filter']);
      $todos->whereIn('completed', $filter);
    }
    if (isset($request->filteredData['search'])) {
      $search = $request->filteredData['search'];
      $todos->where('text', 'LIKE', "%$search%");
    }
    $todos = $todos->orderBy('order', 'desc')->paginate($request->perPage);
    return response()->json($todos, 200);
  }

  /**
   * @throws AuthorizationException
   */
  private function isAuthorized(Todo $todo, string $action): void
  {
    if ($todo->user_id !== auth()->id()) throw new AuthorizationException("You are not authorized to $action this todo.");
  }

  private function filter($filter): array
  {
    if ($filter === 'active') {
      return [0];
    } elseif ($filter === 'completed') {
      return [1];
    } else {
      return [0, 1];
    }
  }

  public function updateOrder(Request $request, Todo $todo): JsonResponse
  {
    $todo->update(['order' => $request->newOrder]);
    auth()->user()->todos()->where('order', '>=', $todo->order)->whereNot('id', $todo->id)->increment('order');
    return response()->json(['message' => 'Changes saved successfully'], 200);
  }
}
