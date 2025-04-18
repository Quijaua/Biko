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
        Schema::table('alunos', function (Blueprint $table) {
            $table->unsignedBigInteger('povo_indigenas_id')->nullable();

            $table->foreign('povo_indigenas_id')->references('id')->on('povo_indigenas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['povo_indigenas_id']);
            $table->dropColumn('povo_indigenas_id');
        });
    }
};
