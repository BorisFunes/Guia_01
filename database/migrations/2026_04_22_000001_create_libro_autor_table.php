<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Libro_Autor', function (Blueprint $table) {
            $table->foreignId('id_libro')
                ->constrained('Libros')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('id_autor')
                ->constrained('Autores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->primary(['id_libro', 'id_autor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Libro_Autor');
    }
};
