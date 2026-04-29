<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            // Solo crea la columna si NO existe previamente
            if (!Schema::hasColumn('materials', 'categoria')) {
                $table->string('categoria')->nullable()->after('clasificacion');
            }
            
            if (!Schema::hasColumn('materials', 'visibilidad')) {
                $table->string('visibilidad')->default('Público')->after('categoria');
            }
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['categoria', 'visibilidad']);
        });
    }
};