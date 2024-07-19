<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

  public function isOwner(User $user, Todo $todo): bool
  {
    return $user->id === $todo->user_id;
  }
}
