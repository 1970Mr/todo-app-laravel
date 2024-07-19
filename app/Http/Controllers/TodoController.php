<?php

namespace App\Http\Controllers;

use App\DTOs\TodoDTO;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Todo;
use App\Services\Todo\TodoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TodoController extends Controller
{
  public function __construct(private readonly TodoService $todoService)
  {
    $this->middleware('can:isOwner,todo')->only(['update', 'destroy', 'updateOrder']);
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
    $todo->update($request->validated());
    return response()->json($todo);
  }

  public function destroy(Todo $todo): JsonResponse
  {
    $todo->delete();
    return response()->json(null, 204);
  }

  public function get(Request $request): JsonResponse
  {
    $todos = $this->todoService->getTodos(
      $request->get('perPage', 5),
      $request->get('statusFilter'),
      $request->get('search'),
    );
    return response()->json($todos);
  }

  public function updateOrder(UpdateOrderRequest $request, Todo $todo): JsonResponse
  {
    $this->todoService->updateOrder($todo, $request->get('newOrder'));
    return response()->json();
  }
}
