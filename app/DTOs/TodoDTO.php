<?php

namespace App\DTOs;

class TodoDTO
{
  public function __construct(
    public string $text,
    public ?int $completed = null,
    public ?int $order = null
  )
  {
  }

  public function items(): array
  {
    return [
      'text' => $this->text,
      'completed' => $this->completed,
      'order' => $this->order,
    ];
  }
}
