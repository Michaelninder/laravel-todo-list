<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignID('user_id');
            $table->string('name')->default('New Todo List');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    
        Schema::create('todo_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('list_id');
            $table->string('name');
            $table->enum('state', ['done', 'in_progress', 'open', 'cancelled'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_lists');
    }
};
