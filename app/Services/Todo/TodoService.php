<?php

namespace App\Services\Todo;

use App\DTOs\TodoDTO;
use App\Enums\TaskStatus;
use App\Models\Todo;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoService
{
  public function createTodo(TodoDTO $todoDTO): Todo
  {
    $user = auth()->user();
    $todo = $user->todos()->make($todoDTO->items());
    $lastPosition = $user->todos()->max('position') ?? 0;
    $todo->position = $lastPosition + 1;
    $todo->save();
    return $todo;
  }

  public function getTodos(int $perPage = 5, ?string $status = null, ?string $search = null): Paginator
  {
    $todosQuery = $this->getUserTodosQuery();
    $this->checkStatus($status, $todosQuery);
    $this->adjustSearch($search, $todosQuery);
    return $todosQuery->orderBy('position', 'desc')->paginate($perPage);
  }

  private function checkStatus(?string $statusName, Builder $todosQuery): void
  {
    if (!$statusName) {
      return;
    }
    $statusValue = $this->getStatus($statusName);
    if ($statusValue !== null) {
      $todosQuery->where('status', $statusValue);
    }
  }

  private function getStatus($status): ?TaskStatus
  {
    return match ($status) {
      'active' => TaskStatus::Active,
      'completed' => TaskStatus::Completed,
      default => null,
    };
  }

  private function adjustSearch(?string $search, Builder $todosQuery): void
  {
    if (!$search) {
      return;
    }
    $todosQuery->where('text', 'LIKE', "%$search%");
  }

  public function updatePosition(Todo $todo, $newPosition): void
  {
    DB::beginTransaction();
    try {
      $todo->update(['position' => $newPosition]);
      $this->managePositionUniqueness($todo);
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  private function managePositionUniqueness(Todo $todo): void
  {
    $positionNotUnique = $this->getUserTodosQuery()
      ->where('position', $todo->position)
      ->whereNot('id', $todo->id)
      ->exists();
    if ($positionNotUnique) {
      $this->incrementOtherPositions($todo);
    }
  }

  private function incrementOtherPositions(Todo $todo): void
  {
    $this->getUserTodosQuery()
      ->where('position', '>=', $todo->position)
      ->whereNot('id', $todo->id)
      ->increment('position');
  }

  private function getUserTodosQuery(): Builder
  {
    return Todo::query()->where('user_id', Auth::id());
  }
}
