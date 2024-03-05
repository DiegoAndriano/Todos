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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->integer('points');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('state');
            $table->foreignId('tag_id');
            $table->foreignId('sub_tag_id');
            $table->boolean('highlight')->default(false);
            $table->foreignId('parent_id')->nullable()->references('id')->on('todos');
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
