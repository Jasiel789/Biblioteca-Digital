<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::dropIfExists('multas');
        Schema::create('multas', function (Blueprint $table) {
            $table->id();
            // Relacionamos la multa con el alumno que la debe
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Relacionamos la multa con el préstamo que la causó
            $table->foreignId('prestamo_id')->nullable()->constrained('prestamos')->onDelete('set null');
            
            // Monto de la multa (ej. 50.00)
            $table->decimal('monto', 8, 2);
            // El estado por defecto será "Pendiente" (hasta que el admin marque "Pagado")
            $table->string('estatus')->default('Pendiente'); 
            // Para saber por qué se le multó
            $table->string('motivo')->default('Retraso en devolución de material'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multas');
    }
};