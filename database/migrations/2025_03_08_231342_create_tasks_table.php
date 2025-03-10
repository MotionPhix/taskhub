<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->uuid('uuid')->unique();
      $table->string('title');
      $table->text('description')->nullable();
      $table->enum('status', ['todo', 'in_progress', 'review', 'done'])->default('todo');
      $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
      $table->foreignId('project_id')->constrained()->onDelete('cascade');
      $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
      $table->foreignId('created_by')->constrained('users');
      $table->timestamp('due_date')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tasks');
  }
};
