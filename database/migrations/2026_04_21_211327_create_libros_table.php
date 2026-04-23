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
        Schema::create('Libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->unsignedInteger('año_publicacion')->nullable();
            $table->foreignId('id_categoria')
                ->nullable()
                ->constrained('Categorias')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Libros');
    }
};
