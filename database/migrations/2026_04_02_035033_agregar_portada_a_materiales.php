<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            if (!Schema::hasColumn('materials', 'portada_url')) {
                // Lo guardaremos como texto largo por si las URLs de internet son muy grandes
                $table->text('portada_url')->nullable()->after('clasificacion'); 
            }
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            if (Schema::hasColumn('materials', 'portada_url')) {
                $table->dropColumn('portada_url');
            }
        });
    }
};