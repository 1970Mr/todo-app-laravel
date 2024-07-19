<?php

namespace App\Services\Todo;

use App\DTOs\TodoDTO;
use App\Models\Todo;

class TodoService
{
  public function createTodo(TodoDTO $todoDTO): Todo
  {
    $user = auth()->user();
    $todo = $user->todos()->make($todoDTO->items());
    $lastOrder = $user->todos()->max('order') ?? 0;
    $todo->order = $lastOrder + 1;
    $todo->save();
    return $todo;
  }

  public function filter($filter): array
  {
    return match ($filter) {
      'active' => [0],
      'completed' => [1],
      default => [0, 1],
    };
  }
}
