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
        Schema::create('comidas', function (Blueprint $table) {
            $table->id();
            $table->string('comida');
            $table->string('precio')->nullable();
            $table->timestamps();
        });

        Schema::create('comidas_comandas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comida_id');
            $table->foreignId('comanda_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comidas');
    }
};
