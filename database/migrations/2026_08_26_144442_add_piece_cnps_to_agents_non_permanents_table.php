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
        Schema::table('agents_non_permanents', function (Blueprint $table) {
            $table->string('type_piece_agentnopermanent', 100)->nullable()->after('date_naissance_nopermanent');
            $table->string('numero_piece_agentnopermanent', 50)->nullable()->after('type_piece_agentnopermanent');
            $table->date('date_piece_etabli_agentnopermanent')->nullable()->after('numero_piece_agentnopermanent');
            $table->string('numero_cnps_agentnopermanent', 50)->nullable()->after('date_piece_etabli_agentnopermanent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents_non_permanents', function (Blueprint $table) {
            $table->dropColumn([
                'type_piece_agentnopermanent',
                'numero_piece_agentnopermanent',
                'date_piece_etabli_agentnopermanent',
                'numero_cnps_agentnopermanent',
            ]);
        });
    }
};
