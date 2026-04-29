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
    Schema::create('prestamos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // El alumno
        $table->foreignId('material_id')->constrained('materials')->onDelete('cascade'); // El libro
        $table->date('fecha_prestamo');
        $table->date('fecha_limite');
        $table->enum('estado', ['Activo', 'Devuelto', 'Vencido'])->default('Activo');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
