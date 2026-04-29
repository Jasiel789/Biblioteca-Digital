<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cambiamos 'materiales' por 'materials'
        Schema::table('materials', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('autor');
        });
    }

    public function down(): void
    {
        // Cambiamos 'materiales' por 'materials'
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
    }
};