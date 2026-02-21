<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->nullable()->after('name');
            $table->string('telefono', 20)->nullable()->after('email');
            $table->string('certificacion')->nullable()->after('telefono');
            $table->unsignedInteger('num_inmersiones')->nullable()->after('certificacion');
            $table->boolean('seguro_buceo')->default(false)->after('num_inmersiones');
            $table->string('idioma_pref', 5)->default('es')->after('seguro_buceo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'apellidos',
                'telefono',
                'certificacion',
                'num_inmersiones',
                'seguro_buceo',
                'idioma_pref',
            ]);
        });
    }
};
