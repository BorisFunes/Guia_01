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
        Schema::create('Prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')
                ->constrained('Usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Prestamos');
    }
};
