<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulletins_salaire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();

            $table->string('mois_paie', 20); // ex: 2024-01
            $table->decimal('indem_transp_cotation', 10, 2)->default(0);
            $table->decimal('igr', 10, 2)->default(0);
            $table->decimal('impot_salaire', 10, 2)->default(0);
            $table->decimal('contrib_nation', 10, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['agent_id', 'mois_paie']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletins_salaire');
    }
};
