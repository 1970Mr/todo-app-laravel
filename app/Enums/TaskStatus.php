<?php

namespace App\Enums;

enum TaskStatus: int
{
  case Active = 0;
  case Completed = 1;

  public static function values(): array
  {
    return array_map(static fn($case) => $case->value, self::cases());
  }
}
