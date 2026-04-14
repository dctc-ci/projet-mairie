<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('situation_familiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->unique()->constrained('agents')->cascadeOnDelete();

            $table->string('situation_mariale', 50)->nullable();
            $table->string('nature_piece', 100)->nullable();
            $table->string('numero_piece', 50)->nullable();
            $table->date('date_etabli_piece')->nullable();

            // Conjoint
            $table->string('nom_prenom_femme', 150)->nullable();
            $table->string('group_sangin', 10)->nullable();
            $table->date('date_mariage')->nullable();
            $table->string('lieu_mariage', 150)->nullable();

            // Enfants (JSON pour gérer plusieurs enfants)
            $table->json('enfants')->nullable();
            // Structure JSON: [{ nom_prenom, date_naissance, lieu_naissance, numero_extrait }]

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('situation_familiales');
    }
};
