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
        Schema::create('codigo_personalizados', function (Blueprint $table) {
            $table->id();

            $table->longText('tag_head')->nullable();
            $table->longText('open_tag_body')->nullable();
            $table->longText('close_tag_body')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigo_personalizados');
    }
};
