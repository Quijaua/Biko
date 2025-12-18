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
        Schema::table('comentarios', function (Blueprint $table) {
            $table->unsignedBigInteger('comentario_id')->nullable()->after('id');
            $table->foreign('comentario_id')->references('id')->on('comentarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['comentario_id']);
            $table->dropColumn('comentario_id');
        });
    }
};
