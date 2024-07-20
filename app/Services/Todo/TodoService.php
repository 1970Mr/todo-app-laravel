<?php

namespace App\Services\Todo;

use App\DTOs\TodoDTO;
use App\Models\Todo;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    $todosQuery = auth()->user()->todos();
    $this->setStatus($status, $todosQuery);
    $this->adjustSearch($search, $todosQuery);
    return $todosQuery->orderBy('position', 'desc')->paginate($perPage);
  }

  private function setStatus(?string $status, HasMany $todosQuery): void
  {
    if (!$status) {
      return;
    }
    $statusList = $this->statusList($status);
    $todosQuery->whereIn('completed', $statusList);
  }

  private function statusList($filter): array
  {
    return match ($filter) {
      'active' => [0],
      'completed' => [1],
      default => [0, 1],
    };
  }

  private function adjustSearch(?string $search, HasMany $todosQuery): void
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
    $positionNotUnique = auth()->user()->todos()
      ->where('position', $todo->position)
      ->whereNot('id', $todo->id)
      ->exists();
    if ($positionNotUnique) {
      $this->incrementOtherPositions($todo);
    }
  }

  private function incrementOtherPositions(Todo $todo): void
  {
    auth()->user()->todos()
      ->where('position', '>=', $todo->position)
      ->whereNot('id', $todo->id)
      ->increment('position');
  }
}
