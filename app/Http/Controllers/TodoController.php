<?php

namespace App\Http\Controllers;

use App\DTOs\TodoDTO;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Models\Todo;
use App\Services\Todo\TodoService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class TodoController extends Controller
{
  public function __construct(private readonly TodoService $todoService)
  {
  }

  public function index(): Response
  {
    return Inertia::render('HomePage');
  }

  public function store(TodoStoreRequest $request): JsonResponse
  {
    $todo = $this->todoService->createTodo(
      new TodoDTO($request->get('text'))
    );
    return response()->json($todo, 201);
  }

  public function update(TodoUpdateRequest $request, Todo $todo): JsonResponse
  {
    try {
      $this->isAuthorized($todo, 'update');
      $todo->update($request->validated());
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
      $filter = $this->todoService->filter($request->filteredData['filter']);
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

  public function updateOrder(Request $request, Todo $todo): JsonResponse
  {
    $this->isAuthorized($todo, 'updateOrder');
    $todo->update(['order' => $request->newOrder]);
    auth()->user()->todos()->where('order', '>=', $todo->order)->whereNot('id', $todo->id)->increment('order');
    return response()->json(['message' => 'Changes saved successfully'], 200);
  }
}
