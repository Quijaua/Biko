<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmbienteVirtualToQuizzesTable extends Migration
{
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('ambiente_virtual_id')->nullable()->after('id')->constrained('ambiente_virtuals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['ambiente_virtual_id']);
            $table->dropColumn('ambiente_virtual_id');
        });
    }
}