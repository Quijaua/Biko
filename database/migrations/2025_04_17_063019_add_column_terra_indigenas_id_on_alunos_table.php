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
            $table->unsignedBigInteger('terra_indigenas_id')->nullable();

            $table->foreign('terra_indigenas_id')->references('id')->on('terra_indigenas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['terra_indigenas_id']);
            $table->dropColumn('terra_indigenas_id');
        });
    }
};
