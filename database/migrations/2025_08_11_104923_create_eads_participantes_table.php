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
        Schema::create('eads_participantes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ead_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('ead_id')->references('id')->on('eads');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('questao_1')->nullable();
            $table->string('questao_2')->nullable();
            $table->string('questao_3')->nullable();
            $table->string('questao_4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eads_participantes');
    }
};
