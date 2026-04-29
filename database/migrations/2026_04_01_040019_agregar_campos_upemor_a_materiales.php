<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            // Verificamos una por una si la columna NO existe, entonces la creamos.
            
            if (!Schema::hasColumn('materials', 'codigo_bibupem')) {
                $table->string('codigo_bibupem')->nullable()->after('id');
            }
            if (!Schema::hasColumn('materials', 'edicion')) {
                $table->string('edicion')->nullable()->after('autor');
            }
            if (!Schema::hasColumn('materials', 'lugar_publicacion')) {
                $table->string('lugar_publicacion')->nullable();
            }
            if (!Schema::hasColumn('materials', 'editorial')) {
                $table->string('editorial')->nullable();
            }
            // Aquí está el culpable, ahora Laravel lo ignorará si ya existe
            if (!Schema::hasColumn('materials', 'isbn')) {
                $table->string('isbn')->nullable();
            }
            if (!Schema::hasColumn('materials', 'clasificacion')) {
                $table->string('clasificacion')->nullable();
            }
            if (!Schema::hasColumn('materials', 'fecha_publicacion')) {
                $table->string('fecha_publicacion')->nullable();
            }

            // Campos Privados (Solo Admin)
            if (!Schema::hasColumn('materials', 'numero_paginas')) {
                $table->integer('numero_paginas')->nullable();
            }
            if (!Schema::hasColumn('materials', 'solicitado_por')) {
                $table->string('solicitado_por')->nullable();
            }
            if (!Schema::hasColumn('materials', 'tipo_adquisicion')) {
                $table->enum('tipo_adquisicion', ['Compra', 'Donación', 'Transferencia'])->nullable();
            }
            if (!Schema::hasColumn('materials', 'precio')) {
                $table->decimal('precio', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('materials', 'fecha_compra')) {
                $table->date('fecha_compra')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            // Solo borramos las columnas si existen
            $columnasParaBorrar = [
                'codigo_bibupem', 'edicion', 'lugar_publicacion', 'editorial', 
                'isbn', 'clasificacion', 'fecha_publicacion', 'numero_paginas', 
                'solicitado_por', 'tipo_adquisicion', 'precio', 'fecha_compra'
            ];

            foreach ($columnasParaBorrar as $columna) {
                if (Schema::hasColumn('materials', $columna)) {
                    $table->dropColumn($columna);
                }
            }
        });
    }
};