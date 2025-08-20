<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('psicologos', function (Blueprint $table) {
            // Define valor padrão como 0
            $table->boolean('supervisora')->default(0)->change();
        });

        // Atualiza registros existentes para 0 caso estejam nulos
        \DB::table('psicologos')->whereNull('supervisora')->update(['supervisora' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('psicologos', function (Blueprint $table) {
            // Remove o default
            $table->boolean('supervisora')->default(null)->change();
        });
    }
};
