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
        Schema::create('coordenador_nucleo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coordenador_id');
            $table->unsignedBigInteger('nucleo_id');
            $table->timestamps();

            $table->foreign('coordenador_id')
                  ->references('id')->on('coordenadores')
                  ->onDelete('cascade');
            $table->foreign('nucleo_id')
                  ->references('id')->on('nucleos')
                  ->onDelete('cascade');

            $table->unique(['coordenador_id', 'nucleo_id']);
        });

        // Schema::table('coordenadores', function (Blueprint $table) {
        //     $table->dropForeign(['id_nucleo']);
        //     $table->dropColumn('id_nucleo');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordenador_nucleo');

        Schema::table('coordenadores', function (Blueprint $table) {
            $table->string('id_nucleo')->nullable();
        });
    }
};
