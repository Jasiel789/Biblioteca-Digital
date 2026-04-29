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
    Schema::create('materials', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('autor');
        $table->string('isbn')->nullable();
        $table->enum('tipo', ['Libro', 'Revista', 'CD', 'Tesis']);
        $table->string('etiqueta_color')->default('Verde'); // RF-02.1 Regla de días
        $table->boolean('es_digital')->default(false);
        $table->enum('privacidad', ['Pública', 'Confidencial'])->default('Pública'); // RF-01.2
        $table->integer('stock_fisico')->default(1);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
