<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
  use HasFactory;

  protected $fillable = [
    'text',
    'completed',
    'order',
    'user_id',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected function completed(): Attribute
  {
    return Attribute::make(
      get: static fn(?string $value) => (bool)$value,
      set: static fn(?string $value) => (bool)$value,
    );
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
