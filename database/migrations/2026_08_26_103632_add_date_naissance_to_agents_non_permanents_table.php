<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents_non_permanents', function (Blueprint $table) {
            $table->date('date_naissance_nopermanent')->nullable()->after('sexe_nopermanent');
        });
    }

    public function down(): void
    {
        Schema::table('agents_non_permanents', function (Blueprint $table) {
            $table->dropColumn('date_naissance_nopermanent');
        });
    }
};
