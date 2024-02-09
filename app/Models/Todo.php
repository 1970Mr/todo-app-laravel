<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
  use HasFactory;

  protected $fillable = [
    'text',
    'completed',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected function completed(): Attribute
  {
    return Attribute::make(
      get: static fn(string $value) => (bool)$value,
      set: static fn(string $value) => (int)$value,
    );
  }
}
