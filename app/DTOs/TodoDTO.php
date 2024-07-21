<?php

namespace App\DTOs;

use App\Enums\TaskStatus;

class TodoDTO
{
  public function __construct(
    public string $text,
    public int|TaskStatus $status = TaskStatus::Active,
    public ?int $position = null
  )
  {
  }

  public function items(): array
  {
    return [
      'text' => $this->text,
      'status' => $this->status,
      'position' => $this->position,
    ];
  }
}
