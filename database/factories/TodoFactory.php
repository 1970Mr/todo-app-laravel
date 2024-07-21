<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
  private $lastPosition;
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $user_id = User::first()->id;
    return [
      'text' => fake()->text(40),
      'status' => Arr::random(TaskStatus::values()),
      'position' => 0,
      'user_id' => $user_id,
    ];
  }

  public function configure(): static
  {
    $this->lastPosition = Todo::latest()->first()?->position ?? 0;
    return $this->afterMaking(function (Todo $todo){
      $todo->position = ++$this->lastPosition;
    });
  }
}
