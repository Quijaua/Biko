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
        Schema::create('gerals', function (Blueprint $table) {
            $table->id();

            $table->string('nome_cursinho')->nullable();
            $table->string('banner')->nullable();
            $table->string('texto_pre_cadastro')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerals');
    }
};
