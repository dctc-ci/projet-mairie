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
        Schema::create('bareme_salarials', function (Blueprint $table) {
            $table->id();
            $table->string('categorie', 50);
            $table->string('echelon', 50);
            $table->integer('indice');
            $table->decimal('salaire_base', 12, 2)->default(0);
            $table->decimal('salaire_brut', 12, 2)->default(0);
            $table->decimal('indem_residence', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bareme_salarials');
    }
};
