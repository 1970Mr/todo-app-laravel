<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
  use HasFactory;

  protected $fillable = [
    'text',
    'status',
    'position',
    'user_id',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected function casts(): array
  {
    return [
      'status' => TaskStatus::class
    ];
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
