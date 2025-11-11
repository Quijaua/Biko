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
        Schema::table('aluno_info_familiares', function (Blueprint $table) {
            $table->dropForeign('aluno_info_familiares_id_aluno_foreign');
            $table->dropForeign('aluno_info_familiares_id_user_foreign');

            $table->foreign('id_aluno')->references('id')->on('alunos')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aluno_info_familiares', function (Blueprint $table) {
            //
        });
    }
};
