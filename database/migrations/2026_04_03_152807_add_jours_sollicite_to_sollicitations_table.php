<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sollicitations', function (Blueprint $table) {
            // Jours réellement sollicités (calculé auto depuis cessation → reprise)
            $table->integer('jours_sollicite')->default(0)->after('type_sollicitation_id');
        });
    }

    public function down(): void
    {
        Schema::table('sollicitations', function (Blueprint $table) {
            $table->dropColumn('jours_sollicite');
        });
    }
};
