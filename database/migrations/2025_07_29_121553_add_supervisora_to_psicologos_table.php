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
        Schema::table('psicologos', function (Blueprint $table) {
            $table->boolean('supervisora')->default(false)->after('email');
            $table->boolean('user_id')->after('supervisora');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psicologos', function (Blueprint $table) {
            $table->dropColumn('supervisora');
            $table->dropColumn('user_id');
        });
    }
};
