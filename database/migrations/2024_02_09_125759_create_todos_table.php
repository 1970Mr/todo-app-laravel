<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('todos', static function (Blueprint $table) {
      $table->id();
      $table->string('text');
      $table->tinyInteger('status')->default(TaskStatus::Active)->comment("0: Active, 1: Completed");
      $table->integer('position')->default(0);
      $table->foreignId('user_id')->constrained('users');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('todos');
  }
};
