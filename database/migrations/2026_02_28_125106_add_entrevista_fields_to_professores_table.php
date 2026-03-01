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
        Schema::table('professores', function (Blueprint $table) {
            $table->boolean('Entrevistado')
                  ->default(false)
                  ->after('MotivoPrincipal');

            $table->text('ComentariosEntrevista')
                  ->nullable()
                  ->after('Entrevistado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professores', function (Blueprint $table) {
            $table->dropColumn([
                'Entrevistado',
                'ComentariosEntrevista'
            ]);
        });
    }
};
