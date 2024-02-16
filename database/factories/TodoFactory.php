<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
  private $lastOrder;
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $lastOrder = Todo::latest()->first()?->order ?? 0;
    $user_id = User::first()->id;
    return [
      'text' => fake()->text(40),
      'completed' => Arr::random([0, 1]),
      'order' => 0,
      'user_id' => $user_id,
    ];
  }

  public function configure(): static
  {
    $this->lastOrder = Todo::latest()->first()?->order ?? 0;
    return $this->afterMaking(function (Todo $todo){
      $todo->order = ++$this->lastOrder;
    });
  }
}
