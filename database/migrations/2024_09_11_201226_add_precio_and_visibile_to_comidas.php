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
        Schema::table('comidas', function (Blueprint $table) {
            $table->string('precio')->nullable();
            $table->boolean('visible')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comidas', function (Blueprint $table) {
            $table->dropColumn('precio');
            $table->dropColumn('visible');
        });
    }
};
