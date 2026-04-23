<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('email', 150)->unique()->nullable();
            $table->string('telefono', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Usuarios');
    }
};
